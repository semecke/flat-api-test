<?php

namespace App\Controller;

use App\Dto\Request\ConfirmationPhone;
use App\Entity\Confirmation;
use App\Exception\DataIncorrectException;
use App\Exception\FailedLoginException;
use App\Exception\SecurityException;
use App\Service\AuthService;
use App\Service\RequestDataHelper;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Dto\Request\User as UserRequest;
use App\Dto\Request\RecoveryPassword as RecoveryPasswordRequest;
use App\Dto\Request\ConfirmationGenerateCode as ConfirmationGenerateCodeRequest;

/**
 * @Route("/login")
 */
class LoginController extends AbstractController
{

    /**
     * @Route("/", name="login", methods={"POST"})
     * @throws DataIncorrectException
     * @throws FailedLoginException
     */
    public function index(
        Request $request,
        RequestDataHelper $requestDataHelper,
        AuthService $authService
    ): Response
    {
        $request_model = $requestDataHelper->validation($request->getContent(), UserRequest::class, 'login');

        $token = $authService->login($request_model, $request->headers->get('User-Agent'), $request->getClientIp());

        return $this->json([
            'success' => true,
            'message' => 'Успешная авторизация!',
            'data' => ['api_token' => $token]
        ]);
    }

}
