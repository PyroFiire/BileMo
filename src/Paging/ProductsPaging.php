<?php

namespace App\Paging;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

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
            //exeption
            return new JsonResponse('Error : page not found, the page must be between 1 and '.$this->maxPages.'.', $status = 404, $headers = [], false);
        }

        $offset = $page * self::NB_PRODUCTS_PAGED;
        return $products = $this->productRepository->findBy([], [], self::NB_PRODUCTS_PAGED, $offset);        
    }
    
}