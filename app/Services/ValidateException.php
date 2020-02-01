<?php

namespace App\Services;


class ValidateException extends \Exception
{
    private $errors;

    public function __construct($message = "", $errors = [])
    {
        $this->errors = $errors;
        parent::__construct($message);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
