<?php


namespace App\Dto\Response;


class Message
{
    public $id;
    public $text;
    public $chat_id;
    public $user_id;
    public $date_create;

    /**
     * @param mixed $id
     */
    public function setId($id): Message
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): Message
    {
        $this->text = $text;
        return $this;
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
     * @param mixed $user_id
     */
    public function setUserId($user_id): Message
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @param mixed $date_create
     */
    public function setDateCreate($date_create): Message
    {
        $this->date_create = $date_create;
        return $this;
    }


}