<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsProductController extends AbstractController
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
     * @Route("/detailsProduct/{id}", methods={"GET"})
    */
    public function detailsProduct($id, Request $request)
    {
        $product = $this->productRepository->findOneById($id);
        
        $serialiseProduct = $this->serializer->serialize($product, 'json');
        //$serialiseProduct = $this->serializer->deserialize($serialiseProduct, Product::class, 'json');

        return new JsonResponse($serialiseProduct, $status = 200, $headers = [], true);
    }
}
