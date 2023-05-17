<?php

namespace App\Services;

use App\Entity\Movie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavoritesService
{
    
    /**
     * le session utilisateur en cours
     *
     * @var SessionInterface
     */
    private $session;

    // TODO : de qui/quoi a-t-on besoin ? des quels services ? de quel classe ?
    // 1. la session : que l'on trouve dans RequestStack (trouvé via la commande debug:autowiring)
    // les besoins en terme de services, donc injection de dépendance
    // doivent être fait au niveau du constructeur
    public function __construct(RequestStack $request)
    {
        $this->session = $request->getSession();
        // ? a but de débug pour voir comment est fait la création de notre service
        // throw new Exception();
    }


    // TODO : quels sont les besoins/fonctionnalités que l'on délègue a ce service
    // 1. list
    // 2. add
    // 3. remove
    // ? ce sont les méthodes qui seront appelées par nos controller
    // il ne faut pas faire d'injection de dépendance dans ces méthodes
    
    public function list()
    {
        $favoris = $this->session->get("favoris", []);

        return $favoris;
    }

    public function add(Movie $movie)
    {
        // TODO améliorer avec un tableau
        $this->session->set("favoris", $movie);
        
    }

    public function remove(Movie $movie)
    {
    $favoris = $this->session->get("favoris", []);

        if ($favoris->getId() == $movie->getId()) {
            // on a trouvé le bon film
            // on vide le favoris, pour le futur on met un tableau vide
            $favoris = [];
            // met à jour la session
            $this->session->set("favoris", $favoris);
        }
    }

}