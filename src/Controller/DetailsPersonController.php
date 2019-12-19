<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Exceptions\ApiException;
use App\Repository\PersonRepository;
use App\Responder\JsonResponder;
use App\Security\Voter\PersonVoter;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
    ) {
        $this->personRepository = $personRepository;
        $this->personVoter = $personVoter;
        $this->security = $security;
        $this->responder = $responder;
    }

    /**
     * @Route("/detailsPerson/{id}", methods={"GET"}, name="detailsPerson")
     * @SWG\Response(
     *     response=200,
     *     description="Returns one product",
     *
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Error : This person not exist.",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Error : You are not authorized to access this resource..",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The id of the person"
     * )
     * @SWG\Tag(name="People")
     * @SecurityDoc(name="Bearer")
     */
    public function detailsPerson($id, Request $request)
    {
        $person = $this->personRepository->findOneById($id);
        if (null == $person) {
            throw new ApiException('This person not exist.', 404);
        }

        $vote = $this->personVoter->vote($this->security->getToken(), $person, ['view']);
        if ($vote < 1) {
            throw new ApiException('You are not authorized to access this resource.', 403);
        }

        $personDTO = new PersonDTO($person);

        return $this->responder->send($request, $personDTO);
    }
}
