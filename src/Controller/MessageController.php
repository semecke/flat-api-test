<?php

namespace App\Controller;

use App\Service\ChatService;
use App\Service\MessageService;
use App\Service\RequestDataHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Dto\Request\Message as MessageRequest;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/send", name="chat-list", methods={"POST"})
     * @throws \Exception
     */
    public function send(
        Request $request,
        ChatService $chatService,
        RequestDataHelper $requestDataHelper,
        MessageService $messageService
    ): Response
    {
        $request_model = $requestDataHelper->validation($request->getContent(), MessageRequest::class, 'send');

        $message = $messageService->send($request_model);

        return $this->json([
            'success' => true,
            'message' => 'Сообщение успешно отправлено!',
            'data' => $message
        ]);
    }
}
