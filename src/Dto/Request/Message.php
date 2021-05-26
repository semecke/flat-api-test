<?php


namespace App\Dto\Request;


use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class Message
{
    /**
     * @Assert\NotBlank(groups={"send"})
     * @Type("integer",groups={"send"})
     * @Assert\GreaterThan(0,groups={"send"})
     */
    public $chat_id;

    /**
     * @Assert\NotBlank(groups={"send"})
     * @Type("string",groups={"send"})
     * @Assert\Length(min=1,max=255,groups={"send"})
     */
    public $text;

    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chat_id;
    }

    /**
     * @param mixed $chat_id
     */
    public function setChatId($chat_id): Message
    {
        $this->chat_id = $chat_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): Message
    {
        $this->text = $text;
        return $this;
    }


}