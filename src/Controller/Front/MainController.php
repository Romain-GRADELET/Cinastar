<?php

namespace App\Controller\Front;

use App\Models\MovieModel;
use App\Repository\CastingRepository;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MainController extends AbstractController
{
    /**
     * page par défaut
     *
     * @Route("/", name="default", methods={"GET", "POST"})
     * 
     * @return Response
     */
    public function home(Request $request, MovieRepository $movieRepository, GenreRepository $genreRepository, PaginatorInterface $paginator): Response
    {

        $allMovies = $movieRepository->findAll();
        //dump($allMovies);

        $allGenres = $genreRepository->findAll();
        //dump($allGenres);


        $allMovies = $paginator->paginate(
            $allMovies, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
    


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
    
        return $this->render("front/main/home.html.twig",
        [
            // les données se passe par un tableau associatif
            // la clé du tableau deviendra le nom de la variable dans twig
            "movieList" => $allMovies,
            "genreList" => $allGenres,
        ]);
        
    }
    // ===============================================================
    /**
     * Page des résultats de recherche
     * 
     * @Route("/search", name="app_front_movie_search", methods={"GET"})
     *
     * @return Response
     */
    public function search(Request $request, MovieRepository $movieRepository, GenreRepository $genreRepository): Response
    {
        $allGenres = $genreRepository->findAll();

        $search = $request->query->get("search", "");
        $movieSearch = $movieRepository->findBySearch($search);
        //dump($allGenres);

        // On peut return directement sur $this pour ne pas mettre une variable intermédiaire
        return $this->render("front/main/search.html.twig", 
        [
            "genreList" => $allGenres,
            "movieSearch" => $movieSearch
        ]);
    }

    // ===============================================================
    /**
     * Page des résultats d'un film/série
     * 
     * @Route("/movies/{id}", name="app_front_show_movie", requirements={"id"="\d+"}), methods={"GET"}
     *
     * @return Response
     */
    public function show($id, MovieRepository $movieRepository, CastingRepository $castingRepository, ReviewRepository $reviewRepository): Response
    {
        // TODO : récuperer le film avec son id
        // $movie = MovieModel::getMovie($id);
        // j'ai une BDD maintenant
        // BBD > Repository > Movie > MovieRepository
        $movie = $movieRepository->find($id);
        //dd($movie);

        // ! Erreur $movie == null si le film n'a pas été trouvé en BDD
        if ($movie === null)
        {
            throw $this->createNotFoundException("Ce film n'existe pas");
        }

        // TODO : récuperer les castings du film, trié par creditOrder
        // BBD : Repository, Casting : CastingRepository : Injection de dépendance
        $allCastingFromMovie = $castingRepository->findBy(
            // * critere de recherche
            // on manipule TOUJOURS des objets
            // donc on parle propriété : movie (de l'objet Casting)
            // cette propriété doit être égale à l'objet $movie
            [
                "movie" => $movie
            ],
            // * orderBy
            // on manipule TOUJOURS des objets
            // on donne la propriété sur laquelle on trie
            // en valeur, on donne le type de tri : ASC/DESC
            [
                "creditOrder" => "ASC"  
            ]
        );

        // TODO : faire une requete avec la jointure entre Casting et Person
        $castingsWithDQL = $castingRepository->findByMovieOrderByCreditOrderWithPerson($movie);
        //dump($allCastingFromMovie);

        // TODO : aller chercher les review du film
        // BBD, repository, Review : injection
        $allReviews = $reviewRepository->findBy(["movie" => $movie],["rating" => "DESC"]);
        
        return $this->render("front/main/show.html.twig",
        [
            "movieId" => $id,
            // TODO fournir le film à ma vue
            "movieForTwig" => $movie,
            // TODO : fournir les casting à la vue
            "allCastingFromBDD" => $allCastingFromMovie,
            // TODO : Fournir les reviews
            "allReviewFromBDD" => $allReviews

        ]);

    }


    

    
}