<?php

namespace App\Entity;

use App\Repository\ApiTokenRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ApiTokenRepository::class)
 *
 * @UniqueEntity(
 *     fields={"token"}
 *     )
 */
class ApiToken
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time_existence;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_create;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_last_use;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_agent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ip_last_use;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="api_tokens", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $p_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTimeExistence(): ?\DateTimeInterface
    {
        return $this->time_existence;
    }

    public function setTimeExistence(\DateTimeInterface $time_existence): self
    {
        $this->time_existence = $time_existence;

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

    public function getDateLastUse(): ?\DateTimeInterface
    {
        return $this->date_last_use;
    }

    public function setDateLastUse(\DateTimeInterface $date_last_use): self
    {
        $this->date_last_use = $date_last_use;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->user_agent;
    }

    public function setUserAgent(string $user_agent): self
    {
        $this->user_agent = $user_agent;

        return $this;
    }

    public function getIpLastUse(): ?string
    {
        return $this->ip_last_use;
    }

    public function setIpLastUse(string $ip_last_use): self
    {
        $this->ip_last_use = $ip_last_use;

        return $this;
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
}
