<?php

namespace App\Controller\Front;

use App\Models\MovieModel;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FavoritesController extends AbstractController
{
   
    /**
     * Afficher le/les film(s) en favoris
     * 
     * @Route("/favorites", name="app_front_favorites_movies", methods={"GET"})
     * 
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function favorites(Request $request): Response
    {

        // TODO : stoker en session les favoris
        // ? où se trouve la session ? dans le cookies de la requete
        // ? où se trouve les informations qui proviennent de la requete ?
        // dans symfony il y un objet Request, tout comme il y a un objet Reponse
        // ? Comment on obtient cet objet Request ?
        // new Request();
        // ! ce n'est pas une bonne idée, car on devrait pas créer nous même une requete
        // il faut demander à symfony, c'est lui qui gère/reçoit la requete
        // Pour demander un objet à Symfony, il suffit de l'ajouter en argument de notre function
        // avec le type hinting Symfony va savoir de quel objet on a besoin
        // dd($request);
        // * cette façon de faire est utilisé dans plusieurs language
        // * cela s'appele l'injection de dépendance
        $session = $request->getSession();
        // dd($session);
        //$session->set('favoris', "Vive les Radium");
        // en PHP, sans symfony : $_SESSION["favoris"] = "Vive les Radium";
        dump($session);

        // TODO : récupérer le film favoris
        $favorisMovie = $session->get('favoris', []);
        //dd($favorisMovie);

        return $this->render("front/favorites/favorites.html.twig",
        [
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
    public function add($id, Request $request, MovieRepository $movieRepository): Response
    {
        // TODO : j'ai besoin de l'identifiant du film à mettre en favoris
        // ? comment l'utilisateur me fournit l'ID ?
        // avec un paramètre de route : {id}
        //dd($id);

        $movie = $movieRepository->find($id);

        // TODO : je veux mettre en session le film pour le garder en favoris
        // pour accéder à la session, il me faut la requete
        // on demande à symfony l'objet request
        // * injection de dépendance
        $session = $request->getSession();

        // j'écrit en session le film que l'utilisateur à mis en favoris
        $session->set("favoris", $movie);

        //dd($session);

        // ? j'ai fini le traitement, je n'ai rien à afficher de particulier
        // je vais donc rediriger mon utilisateur vers l'affichage des favoris
        // càd vers une autre route
        // je renvois de suite cette response 
        return $this->redirectToRoute('app_front_favorites_movies');
    }



}
