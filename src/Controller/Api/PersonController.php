<?php

namespace App\Controller\Api;

use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
