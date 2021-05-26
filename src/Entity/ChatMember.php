<?php

namespace App\Entity;

use App\Repository\ChatMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatMemberRepository::class)
 */
class ChatMember
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chat_members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $p_user;

    /**
     * @ORM\ManyToOne(targetEntity=Chat::class, inversedBy="chat_member")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chat;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="chat_member", orphanRemoval=true)
     */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

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
            $message->setChatMember($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getChatMember() === $this) {
                $message->setChatMember(null);
            }
        }

        return $this;
    }

}
