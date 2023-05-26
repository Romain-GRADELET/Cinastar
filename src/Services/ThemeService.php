<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class ThemeService
{
    /**
     * le requete en cours
     *
     * @var RequestStack
     */
    private $request;

    // TODO : de qui/quoi a-t-on besoin ? des quels services ? de quel classe ?
    // 1. la session : que l'on trouve dans RequestStack (trouvé via la commande debug:autowiring)
    // les besoins en terme de services, donc injection de dépendance
    // doivent être fait au niveau du constructeur
    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    /**
    * get current session
    */
    public function getSession()
    {
        return $this->request->getSession();
    }

    /**
     * Switch du theme Netflix / Allocine
     *
     * @return void
     */
    public function switch()
    {
        // je récupère ce qu'il y a déjà en session
        $session = $this->getSession();

        if ($session->get("theme")){
            $theme = $session->get("theme");

            if ($theme === "Netflix"){
                $session->set("theme", "Allocine");
            }
            else {
                $session->set("theme", "Netflix");
            }
        }
        else{
            $session->set("theme", "Allocine");
        }
        
    }
}