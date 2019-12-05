<?php

namespace App\Paging;

use App\Exceptions\ApiException;
use App\Repository\ProductRepository;

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
        $this->maxPages = intval(ceil($this->nbProducts / self::NB_PRODUCTS_PAGED));
    }

    public function getDatas($page){

        if($page === null){
            return $products = $this->productRepository->findAll();
        }

        if(1 > $page || $page > $this->maxPages){
            throw new ApiException('The page must be between 1 and '.$this->maxPages.'.', 404);
        }

        $offset = self::NB_PRODUCTS_PAGED*($page -1);
        return $products = $this->productRepository->findBy([], [], self::NB_PRODUCTS_PAGED, $offset);        
    }
    
}