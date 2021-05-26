<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use App\Dto\Response\User as UserResponse;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 *
 * @UniqueEntity(fields={"login", "phone"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $login;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @Assert\NotBlank
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="bigint", unique=true)
     */
    private $phone;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="datetime")
     */
    private $date_create;

    /**
     * @ORM\OneToMany(targetEntity=ApiToken::class, mappedBy="p_user", orphanRemoval=true)
     */
    private $api_tokens;

    /**
     * @ORM\OneToMany(targetEntity=ChatMember::class, mappedBy="p_user", orphanRemoval=true)
     */
    private $chat_member;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="p_user", orphanRemoval=true)
     */
    private $messages;

    public function __construct()
    {
        $this->api_tokens = new ArrayCollection();
        $this->chat_member = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|ApiToken[]
     */
    public function getApiTokens(): Collection
    {
        return $this->api_tokens;
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

    public function addApiToken(ApiToken $apiToken): self
    {
        if (!$this->api_tokens->contains($apiToken)) {
            $this->api_tokens[] = $apiToken;
            $apiToken->setPUser($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): self
    {
        if ($this->api_tokens->removeElement($apiToken)) {
            // set the owning side to null (unless already changed)
            if ($apiToken->getPUser() === $this) {
                $apiToken->setPUser(null);
            }
        }

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
            $chatMember->setPUser($this);
        }

        return $this;
    }

    public function removeChatMember(ChatMember $chatMember): self
    {
        if ($this->chat_member->removeElement($chatMember)) {
            // set the owning side to null (unless already changed)
            if ($chatMember->getPUser() === $this) {
                $chatMember->setPUser(null);
            }
        }

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
            $message->setPUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getPUser() === $this) {
                $message->setPUser(null);
            }
        }

        return $this;
    }

    public function getResponseModel(): UserResponse
    {
        return (new UserResponse())
            ->setId($this->getId())
            ->setName($this->getName())
            ->setLogin($this->getLogin());
    }
}
