<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Paging\PeoplePaging;
use App\Security\Voter\PersonVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListOfPeopleController extends AbstractController
{
    private $serializer;
    private $personRepository;

    public function __construct(
        SerializerInterface $serializer,
        PeoplePaging $paging,
        PersonDTO $personDTO
    )
    {
        $this->serializer = $serializer;
        $this->paging = $paging;
        $this->personDTO = $personDTO;
    }

    /**
     * @Route("/people", methods={"GET"})
    */
    public function listOfpeople(Request $request, Security $security, PersonVoter $voter)
    {
        // get a Post object - e.g. query for it
        $people = $this->paging->getDatas($request->query->get('page'));
        // check for "view" access: calls all voters
        //$this->denyAccessUnlessGranted('view', $people[0]);
        //isGranted($attribute, $object, $user = null)
        // ...

        $peopleDTO = $this->personDTO->getPeopleDTO($people);
        
        $serialisePeople = $this->serializer->serialize($peopleDTO, 'json');
        $response = new JsonResponse($serialisePeople, $status = 200, $headers = [], true);
        $response->setSharedMaxAge(3600);
        return $response;
    }
}