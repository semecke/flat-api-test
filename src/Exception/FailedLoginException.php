<?php


namespace App\Exception;


use Throwable;

class FailedLoginException extends \Exception
{
    public $message = 'Логин или пароль неверный';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message == '' ? $this->message : $message;
        parent::__construct($message, $code, $previous);
    }
}