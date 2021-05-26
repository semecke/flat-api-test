<?php


namespace App\Dto\Request;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class ChatHistory
{
    /**
     * @Assert\NotBlank
     * @Type("integer")
     * @Assert\GreaterThan(0)
     */
    public $chat_id;

    /**
     * @Type("integer")
     * @Assert\LessThanOrEqual(200)
     * @Assert\GreaterThan(0)
     */
    public $limit = 100;

    /**
     * @Type("integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    public $offset = 0;

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
    public function setChatId($chat_id): ChatHistory
    {
        $this->chat_id = $chat_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit): ChatHistory
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param mixed $offset
     */
    public function setOffset($offset): ChatHistory
    {
        $this->offset = $offset;
        return $this;
    }


}