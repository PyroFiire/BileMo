<?php

namespace App\Controller;

use App\Paging\ProductsPaging;
use App\Responder\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListOfProductsController
{
    private $responder;
    private $productRepository;

    public function __construct(
        JsonResponder $responder,
        ProductsPaging $paging
    )
    {
        $this->responder = $responder;
        $this->paging = $paging;
    }

    /**
     * @Route("/products", methods={"GET"}, name="listOfProducts")
    */
    public function listOfproducts(Request $request)
    {
        $products = $this->paging->getDatas($request->query->get('page'));

        return $this->responder->send($request, $products);
    }
}
