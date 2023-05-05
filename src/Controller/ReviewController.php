<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    /**
     * @Route("/movie/{id}/addReview", requirements={"id"="\d+"}, name="app_review_create")
     */
    public function create($id, Request $request, MovieRepository $movieRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        // TODO : Récupération des information liées au film
        $movie = $movieRepository->find($id);


        // TODO : Créer un formulaire à partir d'une entité

        // TODO : Traitement du formulaire

        // TODO : Fire notre insertion en BDD 

        // TODO : Donner le formulaire à notre vue




        return $this->render('review/create.html.twig', [
            "movie" => $movie
        ]);
    }
}
