<?php


namespace App\Security;


use App\Exception\FailedLoginException;
use App\Repository\ApiTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $em;
    private $apiTokenRepository;

    public function __construct(
        EntityManagerInterface $em,
        ApiTokenRepository $apiTokenRepository

    )
    {
        $this->em = $em;
        $this->apiTokenRepository = $apiTokenRepository;
    }

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            // you might translate this message
            'message' => 'Необходимо использовать токен для авторизации.'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): bool
    {
        return $request->headers->has('AUTH-TOKEN');
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        return $request->headers->get('AUTH-TOKEN');
    }

    /**
     * @inheritDoc
     * @throws FailedLoginException
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (empty($credentials)) {
            return null;
        }

        $token = $this->apiTokenRepository->findOneBy(['token' => $credentials]);

        if (empty($token)) {
            throw new FailedLoginException('Ваш токен устарел или не существует');
        }

        $token->setDateLastUse(new \DateTime());
        $this->em->persist($token);
        $this->em->flush();

        return $token->getPUser();
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): ?Response
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function supportsRememberMe()
    {
        return false;
    }
}