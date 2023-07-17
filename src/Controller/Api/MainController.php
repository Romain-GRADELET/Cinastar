<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/api/main", name="app_api_main")
     */
    public function index(): Response
    {
        return $this->render('api/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
