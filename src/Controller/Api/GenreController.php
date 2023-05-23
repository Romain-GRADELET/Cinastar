<?php

namespace App\Controller\Api;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/genres", name="app_api_genres_")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(GenreRepository $genreRepository): JsonResponse
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

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id,GenreRepository $genreRepository): JsonResponse
    {
        $genre = $genreRepository->find($id);

        // gestion 404
        if ($genre === null){
            // ! on est dans une API donc pas de HTML
            // throw $this->createNotFoundException();
            return $this->json(
                // on pense UX : on fournit un message
                [
                    "message" => "Ce genre n'existe pas"
                ],
                // le code de status
                Response::HTTP_NOT_FOUND
                // On a pas besoin de préciser les autres arguments
            );
        }

        return $this->json($genre, 200, [], 
            [
                "groups" => 
                [
                    "genre_read",
                    "movie_browse"
                ]
            ]);
    }
}
