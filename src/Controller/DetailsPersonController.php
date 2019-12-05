<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Exceptions\ApiException;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class DetailsPersonController
{
    private $serializer;
    private $personRepository;

    public function __construct(
        SerializerInterface $serializer,
        PersonRepository $personRepository
    )
    {
        $this->serializer = $serializer;
        $this->personRepository = $personRepository;
    }

    /**
     * @Route("/detailsPerson/{id}", methods={"GET"})
     */
    public function detailsPerson($id, Request $request)
    {
        $person = $this->personRepository->findOneById($id);

        if(null == $person){
            throw new ApiException('This person not exist.', 404);
        }

        $personDTO = new PersonDTO($person);
        $serialisePerson = $this->serializer->serialize($personDTO, 'json');
        return new JsonResponse($serialisePerson, $status = 200, $headers = [], true);
    }
}
