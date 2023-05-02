<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Type;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Oflix extends Fixture
{
    /**
     * Création de donnée
     *
     * @param ObjectManager $manager Equivalent à l'EntityManager
     */
    public function load(ObjectManager $manager): void
    {
        // =================================================
        // TODO : Lister les genres de film
        // =================================================

        $allGenres = [
            "Action",
            "Animation",
            "Aventure",
            "Comédie",
            "Dessin animé",
            "Documentaire",
            "Drame",
            "Espionnage",
            "Famille",
            "Fantastique",
            "Historique",
            "Policier",
            "Romance",
            "Science-fiction",
            "Thriller",
            "Western",
        ];

        // On boucle avec un foreach
        foreach ($allGenres as $genre){
            $newGenre = new Genre();

            // * remplir les propriétés
            $newGenre->setName($genre);

            // * appeler la méthode persist avec notre entité
            // on demande la persitance de l'objet
            $manager->persist($newGenre);
        }

        // =================================================
        // TODO : créer les 2 types : film et série
        // =================================================

        $types = [
            'film',
            'série',
        ];

        foreach ($types as $type ) { 
            // on commence par en créer 1, puis on fait une boucle
            // * faire un new
            $newType = new Type();

            // * remplir les propriétés
            $newType->setName($type);

            // * appeler la méthode persist avec notre entité
            // on demande la persitance de l'objet
            $manager->persist($newType);
        }


        // =================================================
        // TODO : Création des films
        // =================================================

        $title = [
            "Super Mario Bros, le film",

        ];
        $typeId = [
            1,

        ];
        $duration = [
            92,

        ];
        $rating = [
            4.2,

        ];
        $summary = [
            "Alors qu’ils tentent de réparer une canalisation souterraine, Mario et son frère Luigi, tous deux plombiers, se retrouvent plongés dans un nouvel univers féerique à travers un mystérieux conduit. Mais lorsque les deux frères sont séparés, Mario s’engage dans une aventure trépidante pour retrouver Luigi.",
            "",
        ];
        $synopsis = [
            "Alors qu’ils tentent de réparer une canalisation souterraine, Mario et son frère Luigi, tous deux plombiers, se retrouvent plongés dans un nouvel univers féerique à travers un mystérieux conduit. Mais lorsque les deux frères sont séparés, Mario s’engage dans une aventure trépidante pour retrouver Luigi.
            Dans sa quête, il peut compter sur l’aide du champignon Toad, habitant du Royaume Champignon, et les conseils avisés, en matière de techniques de combat, de la Princesse Peach, guerrière déterminée à la tête du Royaume. C’est ainsi que Mario réussit à mobiliser ses propres forces pour aller au bout de sa mission. ",

        ];
        $releaseDate = [
            "2023/04/05",

        ];
        $country = [
            "USA",

        ];
        $poster = [
            "https://fr.web.img6.acsta.net/c_150_200/pictures/23/03/20/14/57/4979368.jpg",

        ];

        for ($i=0 ; $i < count($title) ; $i++)
        {
            // Création d'un nouveau film
            $newMovie = new Movie();

            // On rempli les propriétés
            $newMovie->setTitle($title[$i]);
            //$newMovie->setType($typeId[$i]);
            $newMovie->setDuration($duration[$i]);
            $newMovie->setRating($rating[$i]);
            $newMovie->setSummary($summary[$i]);
            $newMovie->setSynopsis($synopsis[$i]);
            $newMovie->setReleaseDate(new DateTime($releaseDate[$i]));
            $newMovie->setCountry($country[$i]);
            $newMovie->setPoster($poster[$i]);

            $manager->persist($newMovie);


        }

        // =================================================
        // TODO : Création des PERSON
        // =================================================



        // =================================================
        // TODO : Création du CASTING
        // =================================================


        // * appeler la méthode flush
        // c'est ici que les requetes SQL sont exécutées
        $manager->flush();
    }
}
