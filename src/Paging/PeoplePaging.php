<?php

namespace App\Paging;

use App\Exceptions\ApiException;
use App\Repository\PersonRepository;
use Symfony\Component\Security\Core\Security;

class PeoplePaging
{
    private const NB_PEOPLE_PAGED = 2;
    private $repository;
    private $security;
    private $nbPeople;
    private $maxPages;
    private $idUserClient;

    public function __construct(
        PersonRepository $repository,
        Security $security
    )
    {
        $this->repository = $repository;
        $this->security = $security;
        $this->idUserClient = $this->security->getUser()->getId();
        $this->nbpeople = $this->repository->count(['userClient'=>$this->idUserClient]);
        $this->maxPages = intval(ceil($this->nbpeople / self::NB_PEOPLE_PAGED));
    }

    public function getDatas($page){

        if($page === null){
            return $people = $this->repository->findBy(['userClient'=>$this->idUserClient], ['email'=>'ASC']);
        }

        if(1 > $page || $page > $this->maxPages){
            throw new ApiException('The page must be between 1 and '.$this->maxPages.'.', 404);
        }

        $offset = self::NB_PEOPLE_PAGED*($page -1);
        return $people = $this->repository->findBy(['userClient'=>$this->idUserClient], ['email'=>'ASC'], self::NB_PEOPLE_PAGED, $offset);        
    }
    
}