<?php

namespace App\Controller;

use App\Models\MovieModel;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * page par défaut
     *
     * @Route("/", name="default", methods={"GET", "POST"})
     * 
     * @return Response
     */
    public function home(Request $request, MovieRepository $movieRepository, GenreRepository $genreRepository): Response
    {

        $allMovies = $movieRepository->findAll();
        //dump($allMovies);

        $allGenres = $genreRepository->findAll();
        //dump($allGenres);

        // TODO : afficher la valeur de la session 'favoris'
        // ? pour accèder à la session, il me faut la requete
        // ? pour avoir la requete, je demande à Symfony : Injection de dépendance
        $session = $request->getSession();
        //dump($session->get("favoris"));



        // la méthode render() prend 2 paramètres:
        // * le nom du fichier de vue que l'on veux utiliser
        // le chemin du fichier tiwg commence dans le dossier templates
        // * un tableau de donnée à afficher
        // cette méthode renvoit un objet Reponse, on va pouvoir le renvoyer
    
        return $this->render("main/home.html.twig",
        [
            // les données se passe par un tableau associatif
            // la clé du tableau deviendra le nom de la variable dans twig
            "movieList" => $allMovies,
            "genreList" => $allGenres,
        ]);
        
    }

    /**
     * Page des résultats de recherche
     * 
     * @Route("/search", name="search_movie", methods={"GET"})
     *
     * @return Response
     */
    public function list(GenreRepository $genreRepository): Response
    {
        $allGenres = $genreRepository->findAll();
        //dump($allGenres);


        // On peut return directement sur $this pour ne pas mettre une variable intermédiaire
        return $this->render("main/list.html.twig", 
        [
            "genreList" => $allGenres
        ]);
    }

    /**
     * Page des résultats d'un film/série
     * 
     * @Route("/movie/{id}", name="show_movie", requirements={"id"="\d+"}), methods={"GET"}
     *
     * @return Response
     */
    public function show($id, MovieRepository $movieRepository): Response
    {
        // TODO : récuperer le film avec son id
        // $movie = MovieModel::getMovie($id);
        // j'ai une BDD maintenant
        // BBD > Repository > Movie > MovieRepository
        $movie = $movieRepository->find($id);
        //dd($movie);

        $twigResponse = $this->render("main/show.html.twig",
        [
            "movieId" => $id,
            // TODO fournir le film à ma vue
            "movieForTwig" => $movie
        ]);

        return $twigResponse;
    }

    
}