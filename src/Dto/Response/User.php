<?php


namespace App\Dto\Response;


class User
{
    public $id;

    public $login;

    public $name;

    /**
     * @param mixed $id
     */
    public function setId($id): User
    {
        $this->id = $id;
        return $this;
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
     * @param mixed $name
     */
    public function setName($name): User
    {
        $this->name = $name;
        return $this;
    }


}