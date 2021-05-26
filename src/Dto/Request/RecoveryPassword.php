<?php


namespace App\Dto\Request;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class RecoveryPassword
{
    /**
     * @Assert\NotBlank
     * @Type("string")
     * @Assert\Length(min=7,max=30)
     */
    public $new_password;

    /**
     * @Assert\NotBlank
     * @Type("integer")
     * @Assert\Length(min=6,max=6)
     */
    public $code;

    /**
     * @Assert\NotBlank
     * @Type("string")
     * @Assert\Length(min=64,max=64)
     */
    public $hash;

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->new_password;
    }

    /**
     * @param mixed $new_password
     * @return $this
     */
    public function setNewPassword($new_password): self
    {
        $this->new_password = $new_password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return $this
     */
    public function setCode($code): self
    {
        $this->code = $code;
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