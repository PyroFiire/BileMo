<?php

namespace App\Controller;

use App\Paging\ProductsPaging;
use App\Repository\ProductRepository;
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
        ProductRepository $productRepository,
        ProductsPaging $paging
    )
    {
        $this->serializer = $serializer;
        $this->productRepository = $productRepository;
        $this->paging = $paging;
    }

    /**
     * @Route("/products", methods={"GET"})
    */
    public function listOfproducts(Request $request)
    {
        $products = $this->paging->getDatas($request->query->get('page'));
        $serialiseProduct = $this->serializer->serialize($products, 'json');
        return new JsonResponse($serialiseProduct, $status = 200, $headers = [], true);
    }
}