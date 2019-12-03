<?php

namespace App\Paging;

use App\Exceptions\ApiException;
use App\Repository\PersonRepository;

class PeoplePaging
{
    private const NB_PEOPLE_PAGED = 5;

    private $repository;
    private $nbPeople;
    private $maxPages;

    public function __construct(
        PersonRepository $repository
    )
    {
        $this->repository = $repository;
        $this->nbpeople = $this->repository->count([]);
        $this->maxPages = intval($this->nbpeople / self::NB_PEOPLE_PAGED);
    }

    public function getDatas($page){

        if($page === null){
            return $people = $this->repository->findAll();
        }

        if(1 > $page || $page > $this->maxPages){
            throw new ApiException('The page must be between 1 and '.$this->maxPages.'.', 404);
        }

        $offset = $page * self::NB_PEOPLE_PAGED;
        return $people = $this->repository->findBy([], [], self::NB_PEOPLE_PAGED, $offset);        
    }
    
}