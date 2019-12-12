<?php

namespace App\Security;

use Symfony\Component\Validator\ConstraintViolationList;

class ErrorsValidator
{

    public function arrayFormatted(ConstraintViolationList $errors)
    {
        $response['code'] = 409 ;
        foreach ($errors as $error) {
            $response[$error->getPropertyPath()] = $error->getMessage();
        }
        return $response;
    }
}