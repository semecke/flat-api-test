<?php


namespace App\Dto\Request;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class ConfirmationGenerateCode
{
    /**
     * @Assert\NotBlank
     * @Type("integer")
     * @Assert\Length(min=10,max=10)
     */
    public $phone;

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): ConfirmationGenerateCode
    {
        $this->phone = $phone;
        return $this;
    }

}