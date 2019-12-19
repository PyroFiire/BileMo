<?php

namespace App\Security;

use Symfony\Component\Validator\ConstraintViolationList;

class ErrorsValidator
{
    private $errors;

    public function arrayFormatted(ConstraintViolationList $errors)
    {
        foreach ($errors as $error) {
            $this->errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return $this;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
