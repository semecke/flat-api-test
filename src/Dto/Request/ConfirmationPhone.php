<?php


namespace App\Dto\Request;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class ConfirmationPhone
{
    /**
     * @Assert\NotBlank
     * @Type("string")
     * @Assert\Length(min=64,max=64)
     */
    public $hash;

    /**
     * @Assert\NotBlank
     * @Type("integer")
     * @Assert\Length(min=6,max=6)
     */
    public $code;

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash): ConfirmationPhone
    {
        $this->hash = $hash;
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
     */
    public function setCode($code): ConfirmationPhone
    {
        $this->code = $code;
        return $this;
    }


}