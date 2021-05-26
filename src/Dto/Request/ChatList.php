<?php


namespace App\Dto\Request;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class ChatList
{
    /**
     * @Type("integer")
     * @Assert\GreaterThan(0)
     */
    public $user_id;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): ChatList
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): ChatList
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): ChatList
    {
        $this->offset = $offset;
        return $this;
    }


}