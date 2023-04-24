<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController
{
    /**
     * Page par défaut
     *  
     * La route se définit sur la ligne ci-dessous (Attention ce n'est pas un commentaire)
     * @Route("/radium", name="default", methods ={"GET", "POST"})
     * 
     * @return Response
     */
    public function home(): Response
    {
        $firstResponse = new Response('<h1>Salut les radiums</h1>');
        return $firstResponse;
    }
}

