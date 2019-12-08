<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class Response
{

    public function __construct(

    )
    {

    }

    /**
     * @Route("/detailsPerson/{id}", methods={"GET"})
     */
    public function send(String $datas, Int $status, Bool $cache)
    {
        if($cache == true){
            // $response->setEtag(md5($response->getContent()));
            // $response->setPublic(); // make sure the response is public/cacheable
            // $response->isNotModified($request);
            //$response->setSharedMaxAge(30);
        }

        return new JsonResponse($datas, $status, $headers = [], true);
    }
}