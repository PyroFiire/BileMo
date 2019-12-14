<?php

namespace App\Controller;

use App\Exceptions\ApiException;
use App\Responder\JsonResponder;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetailsProductController
{
    private $productRepository;
    private $responder;

    public function __construct(
        ProductRepository $productRepository,
        JsonResponder $responder
    )
    {
        $this->productRepository = $productRepository;
        $this->responder = $responder;
    }

    /**
     * @Route("/detailsProduct/{id}", methods={"GET"}, name="detailsProduct")
    */
    public function detailsProduct($id, Request $request)
    {
        $product = $this->productRepository->findOneById($id);
        if(null == $product){
            throw new ApiException('This product not exist.', 404);
        }

        return $this->responder->send($request, $product);
    }
}
