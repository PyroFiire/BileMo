<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Links\LinksPersonDTOGenerator;
use App\Paging\PeoplePaging;
use App\Responder\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListOfPeopleController
{
    private $responder;
    private $paging;
    private $personDTO;
    private $links;

    public function __construct(
        JsonResponder $responder,
        PeoplePaging $paging,
        PersonDTO $personDTO,
        LinksPersonDTOGenerator $links
    ) {
        $this->responder = $responder;
        $this->paging = $paging;
        $this->personDTO = $personDTO;
        $this->links = $links;
    }

    /**
     * @Route("/people", methods={"GET"}, name="listOfPeople")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return list of people",
     *
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Error : The page must be between X and X."
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="People pagination"
     * )
     * @SWG\Tag(name="People")
     * @SecurityDoc(name="Bearer")
     */
    public function listOfpeople(Request $request)
    {
        $people = $this->paging->getDatas($request->query->get('page'));

        $peopleDTO = $this->personDTO->getPeopleDTO($people);

        $this->links->addLinks($peopleDTO);

        return $this->responder->send($request, $peopleDTO);
    }
}
