<?php

namespace App\Controller\Api;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * @Route("/api/genres", name="app_api_genres")
     */
    public function index(GenreRepository $genreRepository): JsonResponse
    {
        // TODO : lister tout les genres
        // BDD, Genre : GenreRepository
        $allGenres = $genreRepository->findAll();

        // le serializer est caché derrière la méthode json()
        // on lui donne les objets à serializer en JSON, ainsi qu'un contexte
        return $this->json(
            // les données
            $allGenres, 
            // le code de retour : 200 par défaut
            200,
            // les entêtes HTTP, on ne s'en sert pas : []
            [],
            // le contexte de serialisation : les groupes
            [
                "groups" => 
                [
                    "genre_browse"
                ]
            ]
        );
    }
}
