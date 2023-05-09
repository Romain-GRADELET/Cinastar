<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    /**
     * @Route("/movie/{id}/review/add", requirements={"id"="\d+"}, name="app_review_add")
     */
    public function create($id, Request $request, MovieRepository $movieRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        // TODO : afficher le nom du film dans le template
        // BDD, Repository, Movie, MovieRepository : injection de dépendance
        $movie = $movieRepository->find($id);
        // ! si le film n'existe pas : 404
        if ($movie === null){ throw $this->createNotFoundException("ce film n'existe pas");}

        // TODO : Créer un formulaire à partir d'une entité
        // 1.  On créer notre entité pour la lié au formulaire
        $newReviewForForm = new Review();

        // 2. Création du formulaire à partir de notre instance
        $form = $this->createForm(ReviewType::class, $newReviewForForm);

        // // TODO : Traitement du formulaire
        // $form->handleRequest($request);

        // // on regarde si le formulaire a été soumis
        // // on demande à valider les données
        // // ! la validation des données n'est pas activé/utilisable par défaut
        // // * il faut ajouter des Assert dans l'entité
        // if ($form->isSubmitted() && $form->isValid())
        // {
        //     // TODO : faire notre insertion en BDD
        //     // comme le formulaire a décidé des nom des éléments HTML
        //     // ET qu'on lui donne la requete
        //     // il va pouvoir récupérer les données tout seul !
        //     dd($newReviewForForm);

        //     // persist + flush
        //     $entityManagerInterface->persist($newReviewForForm);
        //     $entityManagerInterface->flush();

        //     return $this->redirectToRoute("show_movie");
        // }

        // TODO : Donner le formulaire à notre vue
        return $this->renderForm("review/create.html.twig", [
            "formulaire" => $form,
            "movie" => $movie
        ]);


        
        // return $this->render('review/create.html.twig', [
        //     "movie" => $movie
        // ]);
    }
}
