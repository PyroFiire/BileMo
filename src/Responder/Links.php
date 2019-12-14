<?php

namespace App\Responder;

use App\DTO\PersonDTO;
use App\Entity\Product;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Links
{

    private $serializer;
    private $urlGenerator;

    public function __construct(
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function addLinks($datas)
    {
        if(is_array($datas)){
            foreach ($datas as $object) {
                $this->createLinks($object);
            }
            return;
        }
        $this->createLinks($datas);
        return;
    }

    private function createLinks(Object $object){
        switch (true) {
            case $object instanceof Product:
                $object->set_links(['self' => $this->urlGenerator->generate('detailsProduct', ['id' => $object->getId()], 0),
                                    'list' => $this->urlGenerator->generate('listOfProducts', [], 0)
                ]);
            break;
            case $object instanceof PersonDTO:
                $object->set_links(['self' => $this->urlGenerator->generate('detailsPerson', ['id' => $object->getId()], 0),
                                    'delete' => $this->urlGenerator->generate('deletePerson', ['id' => $object->getId()], 0),
                                    'list' => $this->urlGenerator->generate('listOfPeople', [], 0),
                                    'add' => $this->urlGenerator->generate('addPerson', [], 0)
                ]);
            break;
            
            default:
            break;
        }
    }
}