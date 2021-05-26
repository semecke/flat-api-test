<?php


namespace App\Service;


use App\Dto\Request\ChatHistory;
use App\Dto\Request\ChatList;
use App\Entity\ChatMember;
use App\Entity\Message;
use App\Entity\User;
use App\Exception\EntityNotExist;
use App\Repository\ChatMemberRepository;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use App\Repository\TypeChatRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

use App\Dto\Response\User as UserResponse;
use App\Dto\Response\Chat as ChatResponse;
use App\Dto\Response\Message as MessageResponse;
use App\Dto\Response\ChatHistory as ChatHistoryResponse;

class ChatService
{
    private $em;
    private $errorService;
    private $userRepository;
    private $chatRepository;
    private $typeChatRepository;
    private $chatMemberRepository;
    private $security;
    private $messageRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ErrorService $errorService,
        UserRepository $userRepository,
        ChatRepository $chatRepository,
        TypeChatRepository $typeChatRepository,
        ChatMemberRepository $chatMemberRepository,
        Security $security,
        MessageRepository $messageRepository
    )
    {
        $this->em = $entityManager;
        $this->errorService = $errorService;
        $this->userRepository = $userRepository;
        $this->chatRepository = $chatRepository;
        $this->typeChatRepository = $typeChatRepository;
        $this->chatMemberRepository = $chatMemberRepository;
        $this->security = $security;
        $this->messageRepository = $messageRepository;
    }

    /**
     * @return array
     * @throws \Exception
     * @var ChatList $request_model
     */
    public function getList(ChatList $request_model): array
    {
        if (!empty($request_model->getUserId())) {
            $user_id = $request_model->getUserId();
        } else {
            $user_id = $this->security->getUser()->getId();
        }

        $user = $this->userRepository->findOneBy(['id' => $user_id]);

        if (empty($user)) {
            throw new EntityNotExist('User', $user_id);
        }

        $chat_members = $this->chatMemberRepository->findBy(
            ['p_user' => $user->getId()],
            null,
            $request_model->getLimit(),
            $request_model->getOffset()
        );
        $chats = [];
        foreach ($chat_members as $chat_member) {
            $chats[] = $chat_member->getChat()->getResponseModel();
        }

        return $chats;
    }

    /**
     * @return ChatHistoryResponse
     * @throws EntityNotExist
     * @var ChatHistory $request_model
     */
    public function getHistory(ChatHistory $request_model): ChatHistoryResponse
    {
        $chat = $this->chatRepository->findOneBy(['id' => $request_model->getChatId()]);
        if (empty($chat)) {
            throw new EntityNotExist('Chat', $request_model->getChatId());
        }

        $messages_this_chat = $this->messageRepository->findBy(
            ['chat' => $chat->getId()],
            ['id' => 'DESC'],
            $request_model->getLimit(),
            $request_model->getOffset()
        );
        $messages = [];
        foreach ($messages_this_chat as $message_this_chat) {
            $messages[] = (new MessageResponse())
                ->setId($message_this_chat->getId())
                ->setChatId($message_this_chat->getId())
                ->setText($message_this_chat->getText())
                ->setUserId($message_this_chat->getPUser()->getId());
        }

        return (new ChatHistoryResponse())
            ->setChatId($chat->getId())
            ->setChatMember($chat->getResponseChatMember())
            ->setChatMessage($messages);
    }
}