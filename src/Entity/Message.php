<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Dto\Response\Message as MessageResponse;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $p_user;

    /**
     * @ORM\ManyToOne(targetEntity=Chat::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_create;

    /**
     * @ORM\ManyToOne(targetEntity=ChatMember::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chat_member;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPUser(): ?User
    {
        return $this->p_user;
    }

    public function setPUser(?User $p_user): self
    {
        $this->p_user = $p_user;

        return $this;
    }

    public function getChat(): ?Chat
    {
        return $this->chat;
    }

    public function setChat(?Chat $chat): self
    {
        $this->chat = $chat;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getChatMember(): ?ChatMember
    {
        return $this->chat_member;
    }

    public function setChatMember(?ChatMember $chat_member): self
    {
        $this->chat_member = $chat_member;

        return $this;
    }

    public function getResponseModel(): MessageResponse
    {
        return (new MessageResponse())
            ->setId($this->getId())
            ->setChatId($this->getChat()->getId())
            ->setUserId($this->getPUser()->getId())
            ->setText($this->getText())
            ->setDateCreate($this->getDateCreate());
    }
}
