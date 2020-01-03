<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Entity\Person;
use App\Links\LinksPersonDTOGenerator;
use App\Responder\JsonResponder;
use App\Security\ErrorsValidator;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddPersonController
{
    private $serializer;
    private $manager;
    private $security;
    private $validator;
    private $errorsValidator;
    private $responder;
    private $links;

    public function __construct(
        SerializerInterface $serializer,
        ObjectManager $manager,
        Security $security,
        ValidatorInterface $validator,
        ErrorsValidator $errorsValidator,
        JsonResponder $responder,
        LinksPersonDTOGenerator $links
    ) {
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->security = $security;
        $this->validator = $validator;
        $this->errorsValidator = $errorsValidator;
        $this->responder = $responder;
        $this->links = $links;
    }

    /**
     * @Route("/person", methods={"POST"}, name="addPerson")
     * * @SWG\Response(
     *     response=201,
     *     description="Returns the created person",
     * )
     * @SWG\Response(
     *     response=409,
     *     description="Invalid : Return all fields with an error",
     * )
     * @SWG\Parameter(
     *     name="Person",
     *     in="body",
     *     description="The person you want add",
     *     @SWG\Schema(
     *         @SWG\Property(property="email", type="string", example="exemple@exemple.com"),
     *         @SWG\Property(property="firstname", type="string", example="John"),
     *         @SWG\Property(property="lastname", type="string", example="Smith")
     *     )
     * )
     * @SWG\Tag(name="People")
     * @SecurityDoc(name="Bearer")
     */
    public function addPerson(Request $request)
    {
        $person = $this->serializer->deserialize($request->getContent(), Person::class, 'json');
        $person->setUserClient($this->security->getUser());

        $errors = $this->validator->validate($person);
        if (count($errors) > 0) {
            return $this->responder->send($request, $this->errorsValidator->arrayFormatted($errors), 409);
        }

        $this->manager->persist($person);
        $this->manager->flush();

        $personDTO = new PersonDTO($person);
        $this->links->addLinks($personDTO);

        return $this->responder->send($request, $personDTO, 201);
    }
}
