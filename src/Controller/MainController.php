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
     * @Route("/radium", name="default", methods={"GET", "POST"})
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
        $twigResponse = $this->render("main/home.html.twig" /** + ViewData optionnel */);
        
        return $twigResponse;
    }
}