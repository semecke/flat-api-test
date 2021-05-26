<?php


namespace App\Service;


use App\Dto\Request\ConfirmationGenerateCode;
use App\Entity\Confirmation;
use App\Exception\SecurityException;
use App\Repository\ConfirmationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class SecurityService
{
    const MAX_ATTEMPT_CHECK_CODE = 3;
    const DURATION_EXIST_CODE = 'PT10M';

    private $em;
    private $errorService;
    private $userRepository;
    private $security;
    private $confirmation_repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ErrorService $errorService,
        UserRepository $userRepository,
        Security $security,
        ConfirmationRepository $confirmation_repository
    )
    {
        $this->em = $entityManager;
        $this->errorService = $errorService;
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->confirmation_repository = $confirmation_repository;
    }

    /**
     * @throws SecurityException|\Exception
     */
    public function generateConfirmationCode($phone, $type): ?string
    {
//        $code = random_int(100000, 999999);
        $code = 123456; // TODO вернуть случайную генерацию

        $hash = md5(random_bytes(100)) . md5(random_bytes(100));
        $confirmation = (new Confirmation())
            ->setPhone($phone)
            ->setDateCreate(new \DateTime())
            ->setTimeExistence((new \DateTime())->add(new \DateInterval(self::DURATION_EXIST_CODE)))
            ->setAttempts(0)
            ->setCode($code)
            ->setConfirmed(false)
            ->setHash($hash)
            ->setType($type)
            ->setIsUse(false);

        $this->em->persist($confirmation);
        $this->em->flush();

        return $confirmation->getHash();
    }

    /**
     * @throws SecurityException
     */
    public function checkConfirmationCode($code, $hash, $type)
    {
        $confirmation_model = $this->confirmation_repository->findOneBy(['hash' => $hash]);
        if (empty($confirmation_model)) {
            throw new SecurityException('Сессия устарела, запросите код ещё раз.');
        }
        if ($confirmation_model->getConfirmed() || $confirmation_model->getIsUse()) {
            throw new SecurityException('Операция уже была подтверждена.');
        }
        if ($confirmation_model->getAttempts() >= self::MAX_ATTEMPT_CHECK_CODE) {
            throw new SecurityException('Превышено количество попыток.');
        }
        if ($confirmation_model->getType() !== $type) {
            throw new SecurityException('Неизвестная ошибка.');
        }

        $confirmation_model->setAttempts($confirmation_model->getAttempts() + 1);
        $this->em->persist($confirmation_model);
        $this->em->flush();

        if ($confirmation_model->getCode() != $code) {
            throw new SecurityException('Код подтверждения неверный.');
        }

        $confirmation_model->setConfirmed(true);
        $this->em->persist($confirmation_model);
        $this->em->flush();
    }

    /**
     * @throws SecurityException
     */
    public function useConfirmation($hash, $type) {
        $confirmation_model = $this->confirmation_repository->findOneBy(['hash' => $hash]);
        if (empty($confirmation_model)) {
            throw new SecurityException('Сессия устарела, запросите код ещё раз.');
        }
        if ($confirmation_model->getType() !== $type) {
            throw new SecurityException('Неизвестная ошибка.');
        }
        if (!$confirmation_model->getConfirmed()) {
            throw new SecurityException('Операция не была подтверждена.');
        }

        $confirmation_model->setIsUse(true);
        $this->em->persist($confirmation_model);
        $this->em->flush();
    }

    /**
     * @throws SecurityException
     */
    public function getPhoneByConfirmationHash($hash, $type): ?int
    {
        $confirmation_model = $this->confirmation_repository->findOneBy(['hash' => $hash]);
        if (empty($confirmation_model)) {
            throw new SecurityException('Сессия устарела, запросите код ещё раз.');
        }
        if ($confirmation_model->getType() !== $type) {
            throw new SecurityException('Неизвестная ошибка.');
        }
        if (!$confirmation_model->getConfirmed()) {
            throw new SecurityException('Операция не была подтверждена.');
        }

        return $confirmation_model->getPhone();
    }
}