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

        if(get_class($exception) === 'Exception'){
            $code = $exception->getCode();
        } else {
            $code = $exception->getStatusCode();
        }

        $response = ['code' => $code,
                     'message' => $exception->getMessage(),
        ];
        
        $serialiseResponse = $this->serializer->serialize($response, 'json');
        $jsonResponse = new JsonResponse($serialiseResponse, $code, $headers = [], true);
        $event->setResponse($jsonResponse);
    }
}