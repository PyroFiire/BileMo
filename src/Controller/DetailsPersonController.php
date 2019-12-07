<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Exceptions\ApiException;
use App\Security\Voter\PersonVoter;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class DetailsPersonController
{
    private $serializer;
    private $personRepository;
    private $personVoter;

    public function __construct(
        SerializerInterface $serializer,
        PersonRepository $personRepository,
        PersonVoter $personVoter,
        Security $security
    )
    {
        $this->serializer = $serializer;
        $this->personRepository = $personRepository;
        $this->personVoter = $personVoter;
        $this->security = $security;
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

        $vote = $this->personVoter->vote($this->security->getToken(), $person, ['view']);
        if($vote < 1){
            throw new ApiException('You are not authorized to access this resource.', 403);
        }

        $personDTO = new PersonDTO($person);
        $serialisePerson = $this->serializer->serialize($personDTO, 'json');
        return new JsonResponse($serialisePerson, $status = 200, $headers = [], true);
    }
}
