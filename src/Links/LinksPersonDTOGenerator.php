<?php

namespace App\Links;

class LinksPersonDTOGenerator extends LinksGenerator
{
    protected function createLinks(object $object)
    {
        $object->set_links(['self' => $this->urlGenerator->generate('detailsPerson', ['id' => $object->getId()], 0),
                            'delete' => $this->urlGenerator->generate('deletePerson', ['id' => $object->getId()], 0),
                            'list' => $this->urlGenerator->generate('listOfPeople', [], 0),
                            'add' => $this->urlGenerator->generate('addPerson', [], 0),
        ]);
    }
}
