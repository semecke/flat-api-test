<?php


namespace App\Dto\Response;

class Chat
{
    public $id;
    public $type;
    public $name;
    public $chat_member;
    public $last_message;

    /**
     * @param mixed $id
     */
    public function setId($id): Chat
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): Chat
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): Chat
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $chat_member
     */
    public function setChatMember($chat_member): Chat
    {
        $this->chat_member = $chat_member;
        return $this;
    }

    /**
     * @param mixed $last_message
     */
    public function setLastMessage($last_message): Chat
    {
        $this->last_message = $last_message;
        return $this;
    }

}