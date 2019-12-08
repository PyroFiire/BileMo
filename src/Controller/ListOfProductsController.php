<?php

namespace App\Controller;

use App\Paging\ProductsPaging;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ListOfProductsController
{
    private $serializer;
    private $productRepository;
    public function __construct(
        SerializerInterface $serializer,
        ProductsPaging $paging
    )
    {
        $this->serializer = $serializer;
        $this->paging = $paging;
    }

    /**
     * @Route("/products", methods={"GET"})
    */
    public function listOfproducts(Request $request)
    {
        $products = $this->paging->getDatas($request->query->get('page'));
        $serialiseProduct = $this->serializer->serialize($products, 'json');
        $response = new JsonResponse($serialiseProduct, $status = 200, $headers = [], true);
        $response->setSharedMaxAge(3600);
        return $response;
    }
}
