<?php

namespace App\Controller\Api;

use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/api/person", name="app_api_person_")
     */
class PersonController extends AbstractController
{
    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read($id, PersonRepository $personRepository): JsonResponse
    {
        $person = $personRepository->find($id);

        // gestion 404
        if ($person === null){
            // ! on est dans une API donc pas de HTML
            // throw $this->createNotFoundException();
            return $this->json(
                // on pense UX : on fournit un message
                [
                    "message" => "Cette personne n'existe pas"
                ],
                // le code de status
                Response::HTTP_NOT_FOUND
                // On a pas besoin de préciser les autres arguments
            );
        }

        return $this->json($person, 200, [], 
    [
        "groups" => 
        [
            "person_read"
        ]
    ]);
    }

    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(PersonRepository $personRepository): JsonResponse
    {
        $persons = $personRepository->findAll();

        return $this->json($persons,200,[], [
            "groups" =>
            [
                "person_list"
            ]
        ]);
    }



}
