<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Exceptions\ApiException;
use App\Responder\JsonResponder;
use App\Security\Voter\PersonVoter;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;

class DetailsPersonController
{
    private $personRepository;
    private $personVoter;
    private $security;
    private $responder;

    public function __construct(
        PersonRepository $personRepository,
        PersonVoter $personVoter,
        Security $security, 
        JsonResponder $responder
    )
    {
        $this->personRepository = $personRepository;
        $this->personVoter = $personVoter;
        $this->security = $security;
        $this->responder = $responder;
    }

    /**
     * @Route("/detailsPerson/{id}", methods={"GET"}, name="detailsPerson")
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
        
        return $this->responder->send($request, $personDTO);
    }
}
