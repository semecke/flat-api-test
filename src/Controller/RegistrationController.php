<?php

namespace App\Controller;

use App\Dto\Request\ConfirmationGenerateCode as ConfirmationGenerateCodeRequest;
use App\Dto\Request\ConfirmationPhone;
use App\Dto\Request\User as UserRequest;
use App\Entity\Confirmation;
use App\Exception\DataIncorrectException;
use App\Exception\SecurityException;
use App\Service\AuthService;
use App\Service\RequestDataHelper;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registration")
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/start", methods={"POST"})
     * @throws DataIncorrectException|SecurityException
     */
    public function start(
        Request $request,
        RequestDataHelper $requestDataHelper,
        AuthService $authService,
        SecurityService $securityService
    ): Response
    {
        $request_model = $requestDataHelper->validation($request->getContent(), ConfirmationGenerateCodeRequest::class);

        $hash = $authService->startRegistration($request_model);

        return $this->json([
            'success' => true,
            'message' => 'Сообщение с кодом подтверждением было успешно отправлено!',
            'data' => [
                'hash' => $hash
            ]
        ]);
    }

    /**
     * @Route("/confirmation-phone", methods={"POST"})
     * @throws DataIncorrectException|SecurityException
     */
    public function confirmationPhone(
        Request $request,
        RequestDataHelper $requestDataHelper,
        AuthService $authService,
        SecurityService $securityService
    ): Response
    {
        /** @var ConfirmationPhone $request_model */
        $request_model = $requestDataHelper->validation($request->getContent(), ConfirmationPhone::class);

        $securityService->checkConfirmationCode($request_model->getCode(), $request_model->getHash(), Confirmation::TYPE_REGISTRATION);

        return $this->json([
            'success' => true,
            'message' => 'Номер успешно подтвержден!',
            'data' => [
                'hash' => $request_model->getHash()
            ]
        ]);
    }

    /**
     * @Route("/final", methods={"POST"})
     * @throws DataIncorrectException|SecurityException
     */
    public function final(
        Request $request,
        RequestDataHelper $requestDataHelper,
        AuthService $authService
    ): Response
    {
        $request_model = $requestDataHelper->validation($request->getContent(), UserRequest::class, 'registration');

        $user = $authService->registration($request_model);

        return $this->json([
            'success' => true,
            'message' => 'Пользователь успешно зарегистрирован!',
            'data' => $user
        ]);
    }
}
