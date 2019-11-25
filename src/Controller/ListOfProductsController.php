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
    private const NB_PRODUCTS_PAGED = 4;

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
        $page = $request->query->get('page');
        $nbProducts = $this->productRepository->count([]);
        $maxPages = intval($nbProducts / self::NB_PRODUCTS_PAGED);

        if($page === null){
            $products = $this->productRepository->findAll();
            $serialiseProduct = $this->serializer->serialize($products, 'json');
            return new JsonResponse($serialiseProduct, $status = 200, $headers = [], true);
        }

        if(1 > $page || $page > $maxPages){
            return new JsonResponse('Error : page not found, the page must be between 1 and '.$maxPages.'.', $status = 404, $headers = [], false);
        }

        $offset = $page * self::NB_PRODUCTS_PAGED;
        $products = $this->productRepository->findBy([], [], self::NB_PRODUCTS_PAGED, $offset);

        $serialiseProduct = $this->serializer->serialize($products, 'json');
        return new JsonResponse($serialiseProduct, $status = 200, $headers = [], true);
    }
}
