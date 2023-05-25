<?php

namespace App\Controller\Front;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ReviewController extends AbstractController
{
    /**
     * @Route("/movies/{id}/review/add", requirements={"id"="\d+"}, name="app_front_review_add")
     * 
     */
    public function create($id, Request $request, MovieRepository $movieRepository, EntityManagerInterface $entityManagerInterface, ReviewRepository $reviewRepository): Response
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

        // TODO : Traitement du formulaire
        // 1. Le formulaire ayant généré le HTML et les names des input
        // Il doit récupérer les données tout seul: on lui donne les infos via l'objet Request (Injection de dépendances)
        $form->handleRequest($request);

        // 2. On vérifie sir le formulaire est soumis ou pas

        if ($form->isSubmitted() && $form->isValid())
        {
            //dd($newReviewForForm);
            /*
            App\Entity\Review {#496 ▼
                -id: null
                -username: "JB avec les radium"
                -email: "nain@porte.koi"
                -content: "azaezaegrhtjyuryf"
                -rating: 5
                -reactions: array:2 [▼
                    0 => "think"
                    1 => "sleep"
                ]
                -watchedAt: DateTimeImmutable @1683669600 {#1007 ▼
                    date: 2023-05-10 00:00:00.0 Europe/Berlin (+02:00)
                }
                -movie: null
                }
            */

            $newReviewForForm->setMovie($movie);
            // 2 solutions pour persist + flush
            // EntityManagerInterface : la seule classe qui à le droit de persist & flush
            $entityManagerInterface->persist($newReviewForForm);
            $entityManagerInterface->flush();

            // Repository de la bonne entité : ReviewRepository
            // $reviewRepository->add($newReview, true);

            // TODO : calcul du rating après l'ajout d'une review
            // récupérer les critiques par film
            $reviewByMovie = $reviewRepository->findBy(["movie" => $movie], ["watchedAt" => "DESC"]);
            $rating = [];
            foreach ($reviewByMovie as $review) {
                $rating[] = $review->getRating();
            }
            $sum = array_sum($rating);
            $count = count($rating);
            if ($count !== 0) {
                $average = round($sum/$count, 1);
            } else {
                $average = 0;
            }
            // on set le résultat dans la BDD entity Movie selon l'id movie passé en paramètre
            $movie->setRating($average);
            $entityManagerInterface->flush();    

            // Redirection vers la page du film
            return $this->redirectToRoute("app_front_show_movie", ["id"=> $movie->getId()]);
        }
 
        // TODO : Donner le formulaire à notre vue
        return $this->renderForm("front/review/create.html.twig", [
            "formulaire" => $form,
            "movie" => $movie
        ]);
    }
}
