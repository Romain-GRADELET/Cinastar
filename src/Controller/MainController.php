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
        $demoData = "Bonjour du mardi matin";
        $twigResponse = $this->render("main/home.html.twig",
        [
            // les données se passe par un tableau associatif
            // la clé du tableau deviendra le nom de la variable dans twig
            "monTexteKilEstBo" => $demoData
        ]);
        
        return $twigResponse;
    }

    /**
     * Page des résultats de recherche
     * 
     * @Route("/search", name="search_movie", methods={"GET"})
     *
     * @return Response
     */
    public function list(): Response
    {
        // On peut return directement sur $this pour ne pas mettre une variable intermédiaire
        return $this->render("main/list.html.twig");
    }

    /**
     * Page des résultats d'un film/série
     * 
     * @Route("/movie/{id}", name="show_movie", requirements={"id"="\d+"}), methods={"GET"}
     *
     * @return Response
     */
    public function show($id): Response
    {
        $twigResponse = $this->render("main/show.html.twig", [
            "movieId" => $id
        ]);

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