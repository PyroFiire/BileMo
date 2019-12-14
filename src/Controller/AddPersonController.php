<?php

namespace App\Controller;

use App\DTO\PersonDTO;
use App\Entity\Person;
use App\Responder\JsonResponder;
use App\Security\ErrorsValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
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

    public function __construct(
        SerializerInterface $serializer,
        ObjectManager $manager,
        Security $security,
        ValidatorInterface $validator,
        ErrorsValidator $errorsValidator,
        JsonResponder $responder
    )
    {
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->security = $security;
        $this->validator = $validator;
        $this->errorsValidator = $errorsValidator;
        $this->responder = $responder;
    }
    /**
     * @Route("/addPerson", methods={"POST"}, name="addPerson")
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
        return $this->responder->send($request, $personDTO, 201);

    }
}
