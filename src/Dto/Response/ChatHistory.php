<?php


namespace App\Dto\Response;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class ChatHistory
{
    public $chat_id;
    public $chat_member;
    public $chat_message;

    /**
     * @param mixed $chat_id
     */
    public function setChatId($chat_id): ChatHistory
    {
        $this->chat_id = $chat_id;
        return $this;
    }

    /**
     * @param mixed $chat_member
     */
    public function setChatMember($chat_member): ChatHistory
    {
        $this->chat_member = $chat_member;
        return $this;
    }

    /**
     * @param mixed $chat_message
     */
    public function setChatMessage($chat_message): ChatHistory
    {
        $this->chat_message = $chat_message;
        return $this;
    }


}