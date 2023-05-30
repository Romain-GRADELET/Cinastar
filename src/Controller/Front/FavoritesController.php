<?php

namespace App\Controller\Front;

use App\Models\MovieModel;
use App\Repository\MovieRepository;
use App\Services\FavoritesService;
use Doctrine\ORM\EntityManagerInterface;
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
     * @return Response
     */
    public function favorites(FavoritesService $favoritesService): Response
    {
        // TODO utiliser le service
        //$favorisList = $favoritesService->list();

        /**
         * @var App\Entity\User
         */
        $currentUser = $this->getUser();
        $favorisList = $currentUser->getFavoris();

        return $this->render('front/favorites/favorites.html.twig', 
        [
            // je donne le film favoris à ma vue pour l'affichage
            "movies" => $favorisList
        ]);
    }


    /**
     * Ajout d'un film dans les favoris
     *
     * @Route("/favorites/add/{id}", name="app_front_favorites_add", requirements={"id"="\d+"})
     * 
     * 
     * @return Response
     */
    public function add($id, MovieRepository $movieRepository, FavoritesService $favoritesService, EntityManagerInterface $entityManager): Response
    {
        // TODO : j'ai besoin de l'identifiant du film à mettre en favoris
        // ? comment l'utilisateur me fournit l'ID ?
        // avec un paramètre de route : {id}
        // dd($id);

        // TODO : Si je ne suis pas connecté -> redirection vers la page de Login
        /**
         * @var App\Entity\User
         */
        $user = $this->getUser();
        if ($user === null){
            return $this->redirectToRoute('app_login');
        }

        // TODO : j'ai besoin des informations du film en question
        $movie = $movieRepository->find($id);

        if ($movie === null){ throw $this->createNotFoundException("ce film n'existe pas.");}

        // TODO utiliser le service
        //$favoritesService->add($movie);
        $movie->addFavori($this->getUser());
        $entityManager->persist($movie);
        $entityManager->flush();

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
     * @Route("/favorites/delete/{id}", name="app_front_favorites_remove", requirements={"id"="\d+"})
     * 
     * @return Response
     */
    public function remove ($id, FavoritesService $favoritesService, MovieRepository $movieRepository, EntityManagerInterface $entityManager): Response
    {

        $movie = $movieRepository->find($id);

        //$favoritesService->remove($movie);
        $movie->removeFavori($this->getUser());
        $entityManager->persist($movie);
        $entityManager->flush();

        // on redirige pour l'affichage
        return $this->redirectToRoute('app_front_favorites_movies');
    }

    /**
     * Supprime tout les favoris
     * 
     * @Route("favorites/clear", name="app_front_favorites_clear")
     *
     * @param FavoritesService $favoritesService
     * @return Response
     */
    public function removeAll(FavoritesService $favoritesService, EntityManagerInterface $entityManager): Response
    {
        //$favoritesService->removeAll();

        /**
         * @var App\Entity\User
         */
        $currentUser = $this->getUser();
        $favorisList = $currentUser->getFavoris();

        foreach ($favorisList as $favoris ){
            $favoris->removeFavori($this->getUser());
            $entityManager->persist($favoris);
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_front_favorites_movies');
    }


}
