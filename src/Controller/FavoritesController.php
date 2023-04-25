<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoritesController extends AbstractController
{
   
    /**
     * Page des favoris
     * 
     * @Route("/favorites", name="favorites_movies", methods={"GET"})
     *
     * @return Response
     */
    public function favorites(): Response
    {
        $twigResponse = $this->render("favorites/favorites.html.twig");

        return $twigResponse;
    }
}
