<?php

namespace App\Paging;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductsPaging
{
    private const NB_PRODUCTS_PAGED = 4;

    private $repository;
    private $nbProducts;
    private $maxPages;

    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->nbProducts = $this->productRepository->count([]);
        $this->maxPages = intval($this->nbProducts / self::NB_PRODUCTS_PAGED);
    }

    public function getDatas($page){

        if($page === null){
            return $products = $this->productRepository->findAll();
        }

        if(1 > $page || $page > $this->maxPages){
            throw new \Exception('The page must be between 1 and '.$this->maxPages.'.', 404);
        }

        $offset = $page * self::NB_PRODUCTS_PAGED;
        return $products = $this->productRepository->findBy([], [], self::NB_PRODUCTS_PAGED, $offset);        
    }
    
}