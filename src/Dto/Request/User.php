<?php


namespace App\Dto\Request;

use Exception;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class User
{
    /**
     * @Assert\NotBlank(groups={"login","registration"})
     * @Type("string",groups={"login","registration"})
     * @Assert\Length(min=4,max=15,groups={"login","registration"})
     */
    public $login;

    /**
     * @Assert\NotBlank(groups={"login","registration"})
     * @Type("string",groups={"login","registration"})
     * @Assert\Length(min=7,max=30,groups={"login","registration"})
     */
    public $password;

    /**
     * @Assert\NotBlank(groups={"registration"})
     * @Type("string",groups={"registration"})
     * @Assert\Length(min=1,max=15,groups={"registration"})
     */
    public $name;

    /**
     * @Assert\NotBlank(groups={"registration"})
     * @Type("string",groups={"registration"})
     * @Assert\Length(min=64,max=64,groups={"registration"})
     */
    public $hash;

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     * @return $this
     */
    public function setHash($hash): self
    {
        $this->hash = $hash;
        return $this;
    }


}