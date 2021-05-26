<?php


namespace App\Service;


use App\Exception\DataIncorrectException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ErrorService
{
    private $validator;

    public function __construct(
        ValidatorInterface $validator
    )
    {
        $this->validator = $validator;
    }

    /**
     * @throws DataIncorrectException
     */
    public function validation($model, $group = null) {
        $errors = $this->validator->validate($model, null, $group);

        if (count($errors) > 0) {
            $errors_array = [];
            foreach ($errors as $error) {
                $errors_array[] = ['key' => $error->getPropertyPath(), 'message' => $error->getMessage()];
            }
            throw new DataIncorrectException($errors_array);
        }
    }
}