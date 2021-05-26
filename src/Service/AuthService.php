<?php


namespace App\Service;


use App\Dto\Request\ConfirmationGenerateCode;
use App\Dto\Request\User as UserRequest;
use App\Dto\Response\User as UserResponse;
use App\Entity\ApiToken;
use App\Entity\Confirmation;
use App\Entity\User;
use App\Exception\DataIncorrectException;
use App\Exception\FailedLoginException;
use App\Exception\SecurityException;
use App\Repository\ApiTokenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthService
{
    const MAX_API_TOKEN = 5;
    const TIME_EXISTENCE_TOKEN = 'P90D';

    private $em;
    private $errorService;
    private $encoder;
    private $userRepository;
    private $apiTokenRepository;
    private $security_service;

    public function __construct(
        EntityManagerInterface $entityManager,
        ErrorService $errorService,
        UserPasswordEncoderInterface $encoder,
        UserRepository $userRepository,
        ApiTokenRepository $apiTokenRepository,
        SecurityService $security_service
    )
    {
        $this->em = $entityManager;
        $this->errorService = $errorService;
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
        $this->apiTokenRepository = $apiTokenRepository;
        $this->security_service = $security_service;
    }

    /**
     * @throws SecurityException
     * @throws \Exception
     */
    public function startRegistration(ConfirmationGenerateCode $request_model): ?string
    {
        $user = $this->userRepository->findOneBy(['phone' => $request_model->getPhone()]);
        if (!empty($user)) {
            throw new \Exception('Этот номер телефона уже зарегестрирован.');
        }

        return $this->security_service->generateConfirmationCode($request_model->getPhone(), Confirmation::TYPE_REGISTRATION);
    }

    /**
     * @throws DataIncorrectException|SecurityException
     */
    public function registration(UserRequest $request_model): UserResponse
    {
        $phone = $this->security_service->getPhoneByConfirmationHash($request_model->getHash(), Confirmation::TYPE_REGISTRATION);

        $user = (new User())
            ->setLogin($request_model->getLogin())
            ->setName($request_model->getName())
            ->setPhone($phone)
            ->setRoles(['ROLE_USER'])
            ->setDateCreate((new \DateTime));
        $user->setPassword($this->encoder->encodePassword($user, $request_model->getPassword()));
        $this->errorService->validation($user);

        $this->security_service->useConfirmation($request_model->getHash(), Confirmation::TYPE_REGISTRATION);

        $this->em->persist($user);
        $this->em->flush();

        return $user->getResponseModel();
    }

    /**
     * @throws FailedLoginException
     * @throws \Exception
     */
    public function login(UserRequest $request_model, $user_agent, $client_ip): ?string
    {
        $user = $this->userRepository->findOneBy(['login' => $request_model->getLogin()]);

        if (empty($user) || !$this->encoder->isPasswordValid($user, $request_model->getPassword())) {
            throw new FailedLoginException();
        }

        $tokens = $this->apiTokenRepository->findBy(['p_user' => $user->getId()], ['date_last_use' => 'DESC']);

        if (count($tokens) >= self::MAX_API_TOKEN) {
            /** @var ApiToken $excess_token */
            $i = 1;
            foreach ($tokens as $excess_token) {
                if ($i >= self::MAX_API_TOKEN) {
                    $this->em->remove($excess_token);
                }
                $i++;
            }
            $this->em->flush();
        }

        $api_token = md5(random_bytes(100)) . md5(random_bytes(100)) . md5(random_bytes(100));
        $new_token = (new ApiToken())
            ->setPUser($user)
            ->setToken($api_token)
            ->setTimeExistence((new \DateTime())->add(new \DateInterval(self::TIME_EXISTENCE_TOKEN)))
            ->setDateCreate(new \DateTime())
            ->setDateLastUse(new \DateTime())
            ->setUserAgent($user_agent)
            ->setIpLastUse($client_ip);

        $this->em->persist($new_token);
        $this->em->flush();

        return $new_token->getToken();
    }
}