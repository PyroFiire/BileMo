<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Paging\PeoplePaging;
use App\Responder\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListOfPeopleController
{
    private $responder;
    private $personRepository;
    private $personDTO;

    public function __construct(
        JsonResponder $responder,
        PeoplePaging $paging,
        PersonDTO $personDTO
    )
    {
        $this->responder = $responder;
        $this->paging = $paging;
        $this->personDTO = $personDTO;
    }

    /**
     * @Route("/people", methods={"GET"})
    */
    public function listOfpeople(Request $request)
    {
        $people = $this->paging->getDatas($request->query->get('page'));

        $peopleDTO = $this->personDTO->getPeopleDTO($people);
        
        return $this->responder->send($request, $peopleDTO);

    }
}