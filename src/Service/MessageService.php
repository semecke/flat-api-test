<?php


namespace App\Service;


use App\Entity\Message;
use App\Exception\EntityNotExist;
use App\Repository\ChatMemberRepository;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use App\Repository\TypeChatRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Dto\Request\Message as MessageRequest;
use App\Dto\Response\Message as MessageResponse;
use Symfony\Component\Security\Core\Security;

class MessageService
{
    private $em;
    private $errorService;
    private $userRepository;
    private $chatRepository;
    private $typeChatRepository;
    private $chatMemberRepository;
    private $messageRepository;
    private $security;

    public function __construct(
        EntityManagerInterface $entityManager,
        ErrorService $errorService,
        UserRepository $userRepository,
        ChatRepository $chatRepository,
        TypeChatRepository $typeChatRepository,
        ChatMemberRepository $chatMemberRepository,
        MessageRepository $messageRepository,
        Security $security
    )
    {
        $this->em = $entityManager;
        $this->errorService = $errorService;
        $this->userRepository = $userRepository;
        $this->chatRepository = $chatRepository;
        $this->typeChatRepository = $typeChatRepository;
        $this->chatMemberRepository = $chatMemberRepository;
        $this->messageRepository = $messageRepository;
        $this->security = $security;
    }

    /**
     * @return MessageResponse
     * @throws EntityNotExist
     * @throws \Exception
     * @var MessageRequest $request_model
     */
    public function send(MessageRequest $request_model): MessageResponse
    {
        $chat = $this->chatRepository->findOneBy(['id' => $request_model->getChatId()]);
        if (empty($chat)) {
            throw new EntityNotExist('Chat', $request_model->getChatId());
        }

        $chat_member = $this->chatMemberRepository->findOneBy(['chat' => $chat->getId(), 'p_user' => $this->security->getUser()->getId()]);
        if (empty($chat_member)) {
            throw new \Exception('Вы не являетесь участником данного чата.');
        }

        $message = (new Message())
            ->setChatMember($chat_member)
            ->setChat($chat)
            ->setPUser($this->security->getUser()->getId())
            ->setDateCreate(new \DateTime())
            ->setText($request_model->getText());

        $this->em->persist($message);
        $this->em->flush();

        return $message->getResponseModel();
    }
}