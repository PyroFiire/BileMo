<?php

namespace App\Security;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class ErrorsValidator
{
    private $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function display(ConstraintViolationList $errors)
    {
        $response['code'] = 409 ;
        foreach ($errors as $error) {
            $response[$error->getPropertyPath()] = $error->getMessage();
        }
        return $responseJson = $this->serializer->serialize($response, 'json');
    }
}