<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * page par défaut
     *
     * @Route("/", name="default", methods={"GET", "POST"})
     * 
     * @return Response
     */
    public function home(): Response
    {
        // la méthode render() prend 2 paramètres:
        // * le nom du fichier de vue que l'on veux utiliser
        // le chemin du fichier tiwg commence dans le dossier templates
        // * un tableau de donnée à afficher
        // cette méthode renvoit un objet Reponse, on va pouvoir le renvoyer
        $twigResponse = $this->render("main/index.html.twig" /** + ViewData optionnel */);
        
        return $twigResponse;
    }

    /**
     * Page des résultats de recherche
     * 
     * @Route("/find", name="list_movie", methods={"GET"})
     *
     * @return Response
     */
    public function list(): Response
    {
        $twigResponse = $this->render("main/list.html.twig");

        return $twigResponse;
    }

    /**
     * Page des résultats d'un film/série
     * 
     * @Route("/movie/{id}", name="show_movie", methods={"GET"}, requirements={"id"="\d+"})
     *
     * @return Response
     */
    public function show(): Response
    {
        $twigResponse = $this->render("main/show.html.twig");

        return $twigResponse;
    }


    /**
     * Page des favoris
     * 
     * @Route("/favorites", name="favorites_movies", methods={"GET"})
     *
     * @return Response
     */
    public function favorites(): Response
    {
        $twigResponse = $this->render("main/favorites.html.twig");

        return $twigResponse;
    }
}