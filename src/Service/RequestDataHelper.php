<?php


namespace App\Service;


use App\Exception\DataIncorrectException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDataHelper
{
    private $serializer;
    private $errorService;

    public function __construct(
        SerializerInterface $serializer,
        ErrorService $errorService
    )
    {
        $this->serializer = $serializer;
        $this->errorService = $errorService;
    }

    /**
     * @throws DataIncorrectException
     * @throws \Exception
     */
    public function validation($request_content, $class, $group = null)
    {
        if (empty($request_content)) {
            throw new \Exception('Не было передано тело запроса.');
        }
        try {
            $request_model = $this->serializer
                ->deserialize($request_content, $class, 'json');
        } catch (\Exception $e) {
            throw new \Exception('Неудачная десериализация тела запроса.');
        }
        $this->errorService->validation($request_model, $group);

        return $request_model;
    }

    /**
     * @throws \Exception
     */
    public function validationGetQuery($query, $class, $group = null) {
        if (!class_exists($class)) {
            throw new \Exception('Данного класса не существует');
        }
        $model = new $class();
        foreach ($query as $param_key => $param_value) {
            $model->$param_key = is_numeric($param_value) ? (int)$param_value : $param_value;
        }

        $this->errorService->validation($model, $group);

        return $model;
    }
}