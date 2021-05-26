<?php

namespace App\Entity;

use App\Repository\TypeChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeChatRepository::class)
 */
class TypeChat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="type_chat", orphanRemoval=true)
     */
    private $chat;

    public function __construct()
    {
        $this->chat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChat(): Collection
    {
        return $this->chat;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chat->contains($chat)) {
            $this->chat[] = $chat;
            $chat->setTypeChat($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chat->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getTypeChat() === $this) {
                $chat->setTypeChat(null);
            }
        }

        return $this;
    }
}
