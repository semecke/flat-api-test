<?php

namespace App\Controller;

use App\Dto\Request\ChatHistory;
use App\Exception\EntityNotExist;
use App\Service\ChatService;
use App\Service\RequestDataHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Dto\Request\ChatHistory as ChatHistoryRequest;
use App\Dto\Request\ChatList as ChatListRequest;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat/history",methods={"GET"})
     * @throws \Exception
     */
    public function history(
        Request $request,
        ChatService $chatService,
        RequestDataHelper $requestDataHelper
    ): Response
    {
        $request_model = $requestDataHelper->validationGetQuery($request->query, ChatHistoryRequest::class);

        $history = $chatService->getHistory($request_model);

        return $this->json([
            'success' => true,
            'message' => 'История сообщений чата успешно получена!',
            'data' => $history
        ]);
    }

    /**
     * @Route("/chat/list", methods={"GET"})
     * @throws \Exception
     */
    public function list(
        Request $request,
        ChatService $chatService,
        RequestDataHelper $requestDataHelper
    ): Response
    {
        $request_model = $requestDataHelper->validationGetQuery($request->query, ChatListRequest::class);

        $chats = $chatService->getList($request_model);

        return $this->json([
            'success' => true,
            'message' => 'Чаты успешно получены!',
            'data' => $chats
        ]);
    }
}
