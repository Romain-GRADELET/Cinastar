<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        //dd($event);
        // on trouve dans l'argument $event :

        // * request, avec pathInfo
        // va nous servir pour tester la route et exclure certaine route

        // * response, avec le content
        $response = $event->getResponse();
        $content = $response->getContent();
        // dd($content);
        // on cherche l'élement HTML où se placer : <div class="container">
        // et on remplace cet élément par notre message
        $modifiedContent = str_replace(
            // notre recherche
            '<div class="container">', 
            // on remplace par ...
            '<div class="container">
                <div class="alert alert-danger">Maintenance prévue jeudi 25 mai à 17h00</div>
            ',
            // sur quel contenu
            $content
        );
        // il reste à mettre à jour le contenu de la response
        $response->setContent($modifiedContent);
        
        // ================version en une seule instruction =======================
        /*
        $event->getResponse()->setContent(str_replace(
            // notre recherche
            '<div class="container">', 
            // on remplace par ...
            '<div class="container">
                <div class="alert alert-danger">Maintenance prévue jeudi 25 mai à 17h00</div>
            ',
            // sur quel contenu
            $response->getContent()
        ));
        */ //=====================================================================

        // comme la méthode renvoit void, pas de return à faire de notre coté.
    }

    public static function getSubscribedEvents(): array
    {
        
        return [
            // En clé le nom de l'évènement 
            // En valeur : le nom de la méthode à exécuter
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
