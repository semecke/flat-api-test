<?php


namespace App\Exception;


use Throwable;

class EntityNotExist extends \Exception
{
    public $message = '';

    public function __construct($entity_name, $id, $message = "", $code = 0, Throwable $previous = null)
    {
        $message = $entity_name . ' c id - ' . $id . ' не существует.';
        parent::__construct($message, $code, $previous);
    }
}