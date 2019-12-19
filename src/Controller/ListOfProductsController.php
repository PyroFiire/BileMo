<?php

namespace App\Controller;

use App\Paging\ProductsPaging;
use App\Responder\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListOfProductsController
{
    private $responder;
    private $productRepository;

    public function __construct(
        JsonResponder $responder,
        ProductsPaging $paging
    ) {
        $this->responder = $responder;
        $this->paging = $paging;
    }

    /**
     * @Route("/products", methods={"GET"}, name="listOfProducts")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns all products",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Error : The page must be between X and X."
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="Product pagination"
     * )
     * @SWG\Tag(name="Products")
     * @SecurityDoc(name="Bearer")
     */
    public function listOfproducts(Request $request)
    {
        $products = $this->paging->getDatas($request->query->get('page'));

        return $this->responder->send($request, $products);
    }
}
