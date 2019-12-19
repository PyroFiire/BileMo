<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class LoginController
{
    /**
     * @Route("/login", methods={"POST"}, name="login")
     * 
     * @SWG\Response(
     *     response=200,
     *     description="Return Bearer Token",
     *     
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Error : Invalid credentials."
     * )
     * @SWG\Parameter(
     *     name="Client",
     *     in="body",
     *     description="Product pagination",
     *     @SWG\Schema(
     *         @SWG\Property(property="username", type="string", example="MyUsername"),
     *         @SWG\Property(property="password", type="string", example="MyPassword")
     *     )
     * )
     * @SWG\Tag(name="Login")
    */
    public function index()
    {

    }
}
