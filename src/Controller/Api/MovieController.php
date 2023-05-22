<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/api/movie", name="app_api_movie_")
     */
class MovieController extends AbstractController
{
    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"})
     */
    public function index($id, MovieRepository $movieRepository): JsonResponse
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
