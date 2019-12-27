<?php

namespace App\Links;

use App\Links\LinksGenerator;


class LinksProductGenerator extends LinksGenerator
{
    protected function createLinks(object $object)
    {
        $object->set_links(['self' => $this->urlGenerator->generate('detailsProduct', ['id' => $object->getId()], 0),
                            'list' => $this->urlGenerator->generate('listOfProducts', [], 0),
        ]);
    }
}
