<?php

namespace App\Controller\Api;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/genres", name="app_api_genres_")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(GenreRepository $genreRepository): JsonResponse
    {
        // TODO : lister tout les genres
        // BDD, Genre : GenreRepository
        $allGenres = $genreRepository->findAll();

        // le serializer est caché derrière la méthode json()
        // on lui donne les objets à serializer en JSON, ainsi qu'un contexte
        return $this->json(
            // les données
            $allGenres, 
            // le code de retour : 200 par défaut
            200,
            // les entêtes HTTP, on ne s'en sert pas : []
            [],
            // le contexte de serialisation : les groupes
            [
                "groups" => 
                [
                    "genre_browse"
                ]
            ]
        );
    }

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id,GenreRepository $genreRepository): JsonResponse
    {
        $genre = $genreRepository->find($id);

        // gestion 404
        if ($genre === null){
            // ! on est dans une API donc pas de HTML
            // throw $this->createNotFoundException();
            return $this->json(
                // on pense UX : on fournit un message
                [
                    "message" => "Ce genre n'existe pas"
                ],
                // le code de status
                Response::HTTP_NOT_FOUND
                // On a pas besoin de préciser les autres arguments
            );
        }

        return $this->json($genre, 200, [], 
            [
                "groups" => 
                [
                    "genre_read",
                    "movie_browse"
                ]
            ]);
    }

    /**
     * ajout d'un genre
     *
     * @Route("",name="add", methods={"POST"})
     * 
     * @return JsonResponse
     */
    public function add(Request $request, SerializerInterface $serializerInterface, GenreRepository $genreRepository)
    {
        // TODO : créer un genre

        // TODO : récuperer les infos fournit par notre utilisateur
        // comme pour les formulaires, on va chercher dans request
        // dans request ce qui nous interesse c'est le contenu
        $jsonContent = $request->getContent();
        
        //dd($jsonContent);
        /* 
        {
            "name": "Radium"
        }
        */
        // TODO : tranformer / deserialiser le json en objet
        // j'utilise le service SerializerInterface pour ça
        /** @var Genre $newGenre */
        $newGenre = $serializerInterface->deserialize(
            // les données à transformer/deserialiser
            $jsonContent,
            // vers quel type d'objet je veux deserialiser
            Genre::class,
            // quel est le format du contenu : json
            'json'
            // le paramètre de contexte nous servira pour les update
        );

        // dd($newGenre);
        /* App\Entity\Genre {#10510 ▼
            -id: null
            -name: "Radium"
            -movies: Doctrine\Common\Collections\ArrayCollection {#9996 ▶}
            }
            */
        // * j'ai un objet Genre, prêt à être envoyé en BDD
        // BDD, Genre, GenreRepository
        $genreRepository->add($newGenre, true);

        //dd($newGenre);
        // TODO : un peu d'UX : on renvoit le bon code de statut : 201
        return $this->json(
            // on fournit l'objet créer
            $newGenre,
            // le code 201 pour la création
            Response::HTTP_CREATED,
            // toujour pas d'entête
            [],
            // on oublie pas le contexte car on serialise un objet
            [
                "groups" =>
                [
                    // j'utilise un groupe déjà existant
                    "genre_read",
                    "movie_browse"
                ]
            ]
        );

    }

    /**
     * edit genre
     *
     * @Route("/{id}",name="edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     *
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @param GenreRepository $genreRepository
     * @return void
     */
    public function edit($id, Request $request, SerializerInterface $serializerInterface, GenreRepository $genreRepository)
    {
        // TODO : mettre à jour un genre
        // 1. Récupérer les nouvelles valeurs avec le JSON
        $jsonContent = $request->getContent();

        // 2. aller chercher en BDD l'existant
        $genre = $genreRepository->find($id);

        // 3. Désérialiser tout en mettant à jour
        $serializerInterface->deserialize(
            // les données
            $jsonContent,
            // le type d'abjet
            Genre::class,
            // le format de donnée
            "json",
            // ? https://symfony.com/doc/5.4/components/serializer.html#deserializing-in-an-existing-object
            // en contexte on précise que l'on veux POPULATE / PEUPLER un objet existant
            [AbstractNormalizer::OBJECT_TO_POPULATE => $genre]
        );
        // * Comme on demandé la mise en jour d'un objet, pas besoin de récupérer la déserialisation
        //dd($genre);
        // 4. flush
        $genreRepository->add($genre, true);

        return $this->json(
            $genre,
            Response::HTTP_OK,
            [],
            [
                "groups" =>
                [
                    "genre_read",
                    "genre_browse"
                ]
            ]
            );
    }


}
