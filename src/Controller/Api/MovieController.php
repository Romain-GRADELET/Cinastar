<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/api/movie", name="app_api_movie_")
     */
class MovieController extends AbstractController
{
    /**
     * list all movies
     * 
     * @Route("",name="browse", methods={"GET"})
     *
     * @param MovieRepository $movieRepository
     * @return JsonResponse
     */
    public function browse(MovieRepository $movieRepository): JsonResponse
    {
        $allMovies = $movieRepository->findAll();
        return $this->json(
            $allMovies,
            Response::HTTP_OK,
            [],
            [
                "groups" => 
                [
                    "movie_browse"
                ]
            ]
        );
    }

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, MovieRepository $movieRepository): JsonResponse
    {
        $movie = $movieRepository->find($id);
        return $this->json($movie, 200, [], 
    [
        "groups" => 
        [
            "movie_read"
        ]
    ]);
    }

    
}
