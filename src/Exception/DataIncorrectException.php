<?php


namespace App\Exception;


use Throwable;

class DataIncorrectException extends \Exception
{
    public $data;
    public $message = 'Данные некорректны';

    public function __construct($data, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        $message = $message == '' ? $this->message : $message;
        parent::__construct($message, $code, $previous);
    }

}