<?php

namespace App\Controller;

use App\Entity\Person;
use App\Security\ErrorsValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddPersonController
{
    private $serializer;
    private $manager;
    private $security;
    private $validator;
    private $errorsValidator;

    public function __construct(
        SerializerInterface $serializer,
        ObjectManager $manager,
        Security $security,
        ValidatorInterface $validator,
        ErrorsValidator $errorsValidator
    )
    {
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->security = $security;
        $this->validator = $validator;
        $this->errorsValidator = $errorsValidator;
    }
    /**
     * @Route("/addPerson", methods={"POST"})
     */
    public function addPerson(Request $request)
    {
        $person = $this->serializer->deserialize($request->getContent(), Person::class, 'json');
        $person->setUserClient($this->security->getUser());

        $errors = $this->validator->validate($person);
        if (count($errors) > 0) {
            return new JsonResponse($this->errorsValidator->display($errors), $status = 409, $headers = [], true);
        }

        $this->manager->persist($person);
        $this->manager->flush();
        return new JsonResponse('{"code" : 201}', $status = 201, $headers = [], true);

    }
}
