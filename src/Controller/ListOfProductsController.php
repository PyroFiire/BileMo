<?php

namespace App\Controller;

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
        ProductRepository $productRepository
    )
    {
        $this->serializer = $serializer;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products", methods={"GET"})
    */
    public function listOfproducts(Request $request)
    {
        $products = $this->productRepository->findAll();

        $serialiseProduct = $this->serializer->serialize($products, 'json');
        return new JsonResponse($serialiseProduct, $status = 200, $headers = [], true);
    }

    /**
     * @Route("/products/page-{page}", methods={"GET"})
    */
    public function listOfproductsPaged($page, Request $request)
    {
        $limit = 4;
        
        if($page < 1){
            return new JsonResponse('Error : page not found, Page can\'t be negative or equal to 0.', $status = 404, $headers = [], false);
        }

        $numberProducts = $this->productRepository->count([]);
        $maxPages = intval($numberProducts / $limit);
        if($page > $maxPages){
            return new JsonResponse('Error : page not found, Page can\'t be superior to '.$maxPages.'.', $status = 404, $headers = [], false);
        }

        $offset = $page * $limit;
        $products = $this->productRepository->findBy([], [], $limit, $offset);

        $serialiseProduct = $this->serializer->serialize($products, 'json');
        return new JsonResponse($serialiseProduct, $status = 200, $headers = [], true);
    }
}
