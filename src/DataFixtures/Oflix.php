<?php

namespace App\DataFixtures;

use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Season;
use App\Entity\Type;
use App\Repository\MovieRepository;
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

        // utilisation de Faker
        // use the factory to create a Faker\Generator instance
        $faker = \Faker\Factory::create('fr_FR');


        // TODO : créer 10 Genres
        $genres = ["Action", "Animation", "Aventure", "Comédie", "Dessin Animé", "Documentaire", "Drame", "Espionnage", "Famille", "Fantastique", "Historique", "Policier", "Romance", "Science-fiction", "Thriller", "Western"];
        // TODO : faire un foreach sur le tableau pour avoir des données plus réaliste
        /** @var Genre[] $allGenre */
        $allGenre = [];
        foreach ($genres as $genreName) {
            // TODO on commence par en créer 1, puis on fait une boucle
            // * faire un new
            $newGenre = new Genre();

            // * remplir les propriétés
            $newGenre->setName($genreName);

            // * appeler la méthode persist avec notre entité
            // on demande la persitance de l'objet
            $manager->persist($newGenre);

            // 4. pour les fixtures : un tableau avec tout les genres
            $allGenre[] = $newGenre;
        }

        // TODO : créer les 2 types : film et série
        $types = ["film", "série"];
        /** @var Type[] $allTypes */
        $allTypes = [];
        foreach ($types as $type) {
            // * faire un new
            $newType = new Type();

            // * remplir les propriétés
            $newType->setName($type);

            // * appeler la méthode persist avec notre entité
            // on demande la persitance de l'objet
            $manager->persist($newType);

            // 4. tableau de fixtures
            $allTypes[] = $newType;
        }

        // TODO : 2000 person
        /** @var Person[] $allPerson */
        $allPerson = [];
        for ($i=0; $i < 2000; $i++) { 
            // 1. faire une nouvelle instance
            $newPerson = new Person();
            //2. remplir les prop
            $newPerson->setFirstname($faker->firstName());
            $newPerson->setLastname($faker->lastName());

            // 3. demander la persitance
            $manager->persist($newPerson);

            // 4. pour les fixtures : un tableau avec toutes les personnes
            $allPerson[] = $newPerson;

        }

        // TODO : créer 100 film
        /** @var Movie[] $allMovies */
        $allMovies = [];
        for ($i=0; $i < 100; $i++) { 
            // 1. instance
            $newMovie = new Movie();
            // 2. prop
            $newMovie->setTitle("Titre #" . $i);
            $newMovie->setDuration(mt_rand(10, 360));
            $newMovie->setRating(mt_rand(0,50) / 10);
            $newMovie->setSummary("lorem ipsum summary");
            $newMovie->setSynopsis("lorem ipsum synopsis");
            // ? https://www.php.net/manual/fr/datetime.construct.php
            $newMovie->setReleaseDate(new DateTime("1970-01-01"));
            $newMovie->setCountry("FR");
            $newMovie->setPoster("https://amc-theatres-res.cloudinary.com/amc-cdn/static/images/fallbacks/DefaultOneSheetPoster.jpg");

            // 2.bis : les associations
            $randomType = $allTypes[mt_rand(0, count($allTypes)-1)];
            $newMovie->setType($randomType);

            // 3. persist
            $manager->persist($newMovie);

            // 4. tableau de fixtures
            $allMovies[] = $newMovie;
        }

        // TODO : création de casting : il nous faut les objets Person ET les objets Movie
        // Pour chaque film, je veux entre 3 et 5 casting
        foreach ($allMovies as $movie) {
            //random nb casting
            $randomNbCasting = mt_rand(3,5);
            for ($i=1; $i <= $randomNbCasting; $i++) { 
                // 1 .
                $newCasting = new Casting();
                // 2. 
                $newCasting->setRole("Role #" . $i);
                $newCasting->setCreditOrder($i);
                // 2.b
                $newCasting->setMovie($movie);
                $randomPerson = $allPerson[mt_rand(0, count($allPerson)-1)];
                $newCasting->setPerson($randomPerson);
                //3. persist
                $manager->persist($newCasting);
            }
        }

        // TODO : association de Genre avec Movie : entre 3 et 5 genre par film
        foreach ($allMovies as $movie) {
            $randomNbGenre = mt_rand(3,5);
            for ($i=0; $i < $randomNbGenre; $i++) { 
                // 1. je cherche un genre aléatoire
                $randomGenre = $allGenre[mt_rand(0, count($allGenre)-1)];
                // 2. je remplit l'association
                $movie->addGenre($randomGenre);
                // 3. pas de persist car les 2 objets (movie / genre) sont déjà connu de Doctrine
            }
        }

        // TODO : association de Season avec Movie : entre 3 et 10 Season par série
        foreach ($allMovies as $movie) {
            // je teste si le type est une série
            if ($movie->getType()->getName() == "série")
            {
                $randomNbSeason = mt_rand(3,10);
                for ($i=1; $i <= $randomNbSeason; $i++) { 
                    // 1. 
                    $newSeason = new Season();
                    // 2. 
                    $newSeason->setNumber($i);
                    $newSeason->setNbEpisodes(mt_rand(12, 24));
                    // 2.b Movie est le porteur, c'est donc avec movie que l'on renseigne l'association
                    $movie->addSeason($newSeason);

                    //3. persist
                    $manager->persist($newSeason);
                }
            }
        }


        // * appeler la méthode flush
        // c'est ici que les requetes SQL sont exécutées
        $manager->flush();
    }
}
