<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Dto\Response\Chat as ChatResponse;
use App\Dto\Response\User as UserResponse;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TypeChat::class, inversedBy="chat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_chat;

    /**
     * @ORM\OneToMany(targetEntity=ChatMember::class, mappedBy="chat", orphanRemoval=true)
     */
    private $chat_member;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="chat", orphanRemoval=true)
     */
    private $messages;

    public function __construct()
    {
        $this->chat_member = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeChat(): ?TypeChat
    {
        return $this->type_chat;
    }

    public function setTypeChat(?TypeChat $type_chat): self
    {
        $this->type_chat = $type_chat;

        return $this;
    }

    /**
     * @return Collection|ChatMember[]
     */
    public function getChatMember(): Collection
    {
        return $this->chat_member;
    }

    public function addChatMember(ChatMember $chatMember): self
    {
        if (!$this->chat_member->contains($chatMember)) {
            $this->chat_member[] = $chatMember;
            $chatMember->setChat($this);
        }

        return $this;
    }

    public function removeChatMember(ChatMember $chatMember): self
    {
        if ($this->chat_member->removeElement($chatMember)) {
            // set the owning side to null (unless already changed)
            if ($chatMember->getChat() === $this) {
                $chatMember->setChat(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setChat($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getChat() === $this) {
                $message->setChat(null);
            }
        }

        return $this;
    }

    public function getResponseModel(): ChatResponse
    {
        return (new ChatResponse())
            ->setId($this->getId())
            ->setType($this->getTypeChat()->getName())
            ->setName($this->getName())
            ->setLastMessage($this->getMessages()->last()->getResponseModel())
            ->setChatMember($this->getResponseChatMember());
    }

    public function getResponseChatMember(): array
    {
        $chat_members = [];
        /** @var ChatMember $chat_member */
        foreach ($this->getChatMember() as $chat_member) {
            $chat_members[] = $chat_member->getPUser()->getResponseModel();
        }

        return $chat_members;
    }

}
