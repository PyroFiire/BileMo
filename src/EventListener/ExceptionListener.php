<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    private $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }
    
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getException();

        $response = ['code' => $exception->getCode(),
                     'message' => $exception->getMessage(),
        ];
        
        $serialiseResponse = $this->serializer->serialize($response, 'json');
        $jsonResponse = new JsonResponse($serialiseResponse, $exception->getCode(), $headers = [], true);
        $event->setResponse($jsonResponse);
    }
}