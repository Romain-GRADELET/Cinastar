<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
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

        //foreach ($types as $type ) { 

            // * faire un new
            $typeFilm = new Type();

            // * remplir les propriétés
            $typeFilm->setName("Film");

            // * appeler la méthode persist avec notre entité
            // on demande la persitance de l'objet
            $manager->persist($typeFilm);


            // * faire un new
            $typeSerie = new Type();

            // * remplir les propriétés
            $typeSerie->setName("Série");

            // * appeler la méthode persist avec notre entité
            // on demande la persitance de l'objet
            $manager->persist($typeSerie);


        //}


        // =================================================
        // TODO : Création des films
        // =================================================

        $title = [
            "Super Mario Bros, le film",
            "Peaky Blinders",
            "Les Gardiens de la Galaxie 2",

        ];
        $type = [
            $typeFilm,
            $typeSerie,
            $typeFilm,

        ];
        $duration = [
            92,
            52,
            136,

        ];
        $rating = [
            4.2,
            4.5,
            4.1,

        ];
        $summary = [
            "Alors qu’ils tentent de réparer une canalisation souterraine, Mario et son frère Luigi, tous deux plombiers, se retrouvent plongés dans un nouvel univers féerique à travers un mystérieux conduit. Mais lorsque les deux frères sont séparés, Mario s’engage dans une aventure trépidante pour retrouver Luigi.",
            "En 1919, à Birmingham, soldats, révolutionnaires politiques et criminels combattent pour se faire une place dans le paysage industriel de l'après-Guerre.",
            "Musicalement accompagné de la \"Awesome Mixtape n°2\" (la musique qu'écoute Star-Lord dans le film), Les Gardiens de la galaxie 2 poursuit les aventures de l'équipe alors qu'elle traverse les confins du cosmos. Les gardiens doivent combattre pour rester unis alors qu'ils découvrent les mystères de la filiation de Peter Quill. Les vieux ennemis vont devenir de nouveaux alliés et des personnages bien connus des fans de comics vont venir aider nos héros et continuer à étendre l'univers Marvel. ",
        ];
        $synopsis = [
            "Alors qu’ils tentent de réparer une canalisation souterraine, Mario et son frère Luigi, tous deux plombiers, se retrouvent plongés dans un nouvel univers féerique à travers un mystérieux conduit. Mais lorsque les deux frères sont séparés, Mario s’engage dans une aventure trépidante pour retrouver Luigi.
            Dans sa quête, il peut compter sur l’aide du champignon Toad, habitant du Royaume Champignon, et les conseils avisés, en matière de techniques de combat, de la Princesse Peach, guerrière déterminée à la tête du Royaume. C’est ainsi que Mario réussit à mobiliser ses propres forces pour aller au bout de sa mission. ",
            "En 1919, à Birmingham, soldats, révolutionnaires politiques et criminels combattent pour se faire une place dans le paysage industriel de l'après-Guerre. Le Parlement s'attend à une violente révolte, et Winston Churchill mobilise des forces spéciales pour contenir les menaces. La famille Shelby compte parmi les membres les plus redoutables. Surnommés les \"Peaky Blinders\" par rapport à leur utilisation de lames de rasoir cachées dans leurs casquettes, ils tirent principalement leur argent de paris et de vol. Tommy Shelby, le plus dangereux de tous, va devoir faire face à l'arrivée de Campbell, un impitoyable chef de la police qui a pour mission de nettoyer la ville. Ne doit-il pas se méfier tout autant de la ravissante Grace Burgess ? Fraîchement installée dans le voisinage, celle-ci semble cacher un mystérieux passé et un dangereux secret. ",
            "Musicalement accompagné de la \"Awesome Mixtape n°2\" (la musique qu'écoute Star-Lord dans le film), Les Gardiens de la galaxie 2 poursuit les aventures de l'équipe alors qu'elle traverse les confins du cosmos. Les gardiens doivent combattre pour rester unis alors qu'ils découvrent les mystères de la filiation de Peter Quill. Les vieux ennemis vont devenir de nouveaux alliés et des personnages bien connus des fans de comics vont venir aider nos héros et continuer à étendre l'univers Marvel. ",
        ];
        $releaseDate = [
            "2023/04/05",
            "2013/01/01",
            "2017/04/26",

        ];
        $country = [
            "USA",
            "UK",
            "USA",

        ];
        $poster = [
            "https://fr.web.img6.acsta.net/c_150_200/pictures/23/03/20/14/57/4979368.jpg",
            "https://fr.web.img5.acsta.net/c_150_200/pictures/22/06/07/11/57/5231272.jpg",
            "https://fr.web.img6.acsta.net/c_310_420/pictures/17/03/01/11/10/438835.jpg",

        ];

        for ($i=0 ; $i < count($title) ; $i++)
        {
            // Création d'un nouveau film
            $newMovie = new Movie();

            // On rempli les propriétés
            $newMovie->setTitle($title[$i]);
            $newMovie->setType($type[$i]);
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

        $firstname = [
            "Chris",
            "Anya",
            "Charlie",
            "Jack",
            "Cillian",
            "Helen",
            "Paul",
            "Zoe",
            "Dave",
            "Michael",

        ];

        $lastname = [
            "Pratt",
            "Taylor-Joy",
            "Day",
            "Black",
            "Murphy",
            "McCrory",
            "Anderson",
            "Saldana",
            "Bautista",
            "Rooker",

        ];

        for ($i=0 ; $i <= count($firstname) ; $i++)
        {
            // Création d'une nouvelle personne
            $newPerson = new Person();

            // On set son firstname et son lastname
            $newPerson->setFirstname($firstname[$i]);
            $newPerson->setLastname($lastname[$i]);

            // On valide l'intégration
            $manager->persist($newPerson);
        }


        // =================================================
        // TODO : Création du CASTING
        // =================================================


        






        // * appeler la méthode flush
        // c'est ici que les requetes SQL sont exécutées
        $manager->flush();
    }
}
