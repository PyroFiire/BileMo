<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="homepage")
     */
    public function index()
    {
        return $this->redirect('/doc');
    }
}
