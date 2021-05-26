<?php

namespace App\Controller;

use App\Dto\Request\RecoveryPassword as RecoveryPasswordRequest;
use App\Exception\DataIncorrectException;
use App\Exception\SecurityException;
use App\Service\AuthService;
use App\Service\RequestDataHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecoveryPasswordController extends AbstractController
{
    /**
     * @Route("/recovery-password", name="recovery-password", methods={"POST"})
     * @throws DataIncorrectException|SecurityException
     */
    public function recoveryPassword(
        Request $request,
        RequestDataHelper $requestDataHelper,
        AuthService $authService
    ): Response
    {
        $request_model = $requestDataHelper->validation($request->getContent(), RecoveryPasswordRequest::class);


    }
}
