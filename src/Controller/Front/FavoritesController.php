<?php

namespace App\Controller\Front;

use App\Models\MovieModel;
use App\Repository\MovieRepository;
use App\Services\FavoritesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\Session;

class FavoritesController extends AbstractController
{
   
    /**
     * Afficher le/les film(s) en favoris
     * 
     * @Route("/favorites", name="app_front_favorites_movies", methods={"GET"})
     * 
     *
     * @return Response
     */
    public function favorites(FavoritesService $favoritesService): Response
    {
        // TODO utiliser le service
        $favorisMovie = $favoritesService->list();

        return $this->render('front/favorites/favorites.html.twig', 
        [
            // je donne le film favoris à ma vue pour l'affichage
            "movie" => $favorisMovie
        ]);
    }


    /**
     * Ajout d'un film dans les favoris
     *
     * @Route("/favorites/add/{id}", name="app_front_favorites_movies_add", requirements={"id"="\d+"})
     * 
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function add($id, MovieRepository $movieRepository, FavoritesService $favoritesService): Response
    {
        // TODO : j'ai besoin de l'identifiant du film à mettre en favoris
        // ? comment l'utilisateur me fournit l'ID ?
        // avec un paramètre de route : {id}
        // dd($id);

        // TODO : j'ai besoin des informations du film en question
        $movie = $movieRepository->find($id);

        if ($movie === null){ throw $this->createNotFoundException("ce film n'existe pas.");}

        // TODO utiliser le service
        $favoritesService->add($movie);

        // ? j'ai fini le traitement, je n'ai rien à afficher de particulier
        // je vais donc rediriger mon utilisateur vers l'affichage des favoris
        // càd vers une autre route
        // la méthode redirectToRoute() me fournit une Response
        // je renvois de suite cette response 
        return $this->redirectToRoute('app_front_favorites_movies');
    }


    /**
     * suppression d'un film dans les favoris
     *
     * @Route("/favorites/delete/{id}", name="app_front_favorites_movies_delete", requirements={"id"="\d+"})
     * 
     * @return Response
     */
    public function delete ($id, Request $request): Response
    {
        // TODO : supprimer un favoris
        // 1. il me faut un id, parce que l'on pense au futur et la gestion de multiple favoris
        // 2. il me faut la session pour récupérer le favoris
        $favoris = $request->getSession()->get("favoris");

        if ($favoris->getId() == $id){
            // on a trouvé le bon film
            // on vide le favoris, pour le futur on met un tableau vide
            $favoris = [];
            // met à jour la session
            $request->getSession()->set("favoris", $favoris);
        }

        // on redirige pour l'affichage
        return $this->redirectToRoute('app_front_favorites_movies');
    }





}
