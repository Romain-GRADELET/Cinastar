<?php

namespace App\DataFixtures;

use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Review;
use App\Entity\Season;
use App\Entity\Type;
use App\Entity\User;
use App\Services\OmdbApi;
use Bluemmb\Faker\PicsumPhotosProvider;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \Xylis\FakerCinema\Provider\Movie as FakerMovieProvider;
use Xylis\FakerCinema\Provider\Person as FakerPersonProvider;
use Xylis\FakerCinema\Provider\TvShow as FakerTvShowProvider;
use \Xylis\FakerCinema\Provider\Character as FakerCharacterProvider;
// possibilité de créer un alias pour éviter les doublons de noms dans le fichier

class Oflix extends Fixture
{
    /**
     * Service OmdbApi
     *
     * @var OmdbApi
     */
    private $omdbApi;

    public function __construct(OmdbApi $omdbApi)
    {
        $this->omdbApi = $omdbApi;
    }

    /**
     * Création de donnée
     *
     * @param ObjectManager $manager Equivalent à l'EntityManager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $fakerFr = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
        $faker->addProvider(new FakerMovieProvider($faker));
        $faker->addProvider(new FakerPersonProvider($faker));
        $faker->addProvider(new FakerTvShowProvider($faker));
        $faker->addProvider(new FakerCharacterProvider($faker));


        // * la création de données
        // 1. faire une nouvelle instance d'une entité
        // 2. remplir toutes les propriétés obligatoires de cette instance
        // 3. demander au manager de persiter l'entité
        // 4. stocker dans un tableau les entités pour les relations futures

        // =======================================================
        // TODO : créer 3 utilisateurs, chacun avec un ROLE
        // =======================================================
        $admin = new User();
        $admin->setEmail("admin@admin.com");
        // * on donne le mot de passe hashé
        // mdp : admin
        $admin->setPassword('$2y$13$a1q0kL/yIixVmCF.cnIR7eqB/fIo9wEalcfC1zPrEnNW61R0kcEga');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setFirstname("admin");
        $admin->setLastname("admin");

        $manager->persist($admin);

        $managerUser = new User();
        $managerUser->setEmail("manager@manager.com");
        // * on donne le mot de passe hashé
        // mdp : manager
        $managerUser->setPassword('$2y$13$ehwmxDazwOE8ol3eTRz/C.YapEQ8UMyDFzolfGCg97gegVtOwjXu6');
        $managerUser->setRoles(['ROLE_MANAGER']);
        $managerUser->setFirstname("manager");
        $managerUser->setLastname("manager");

        $manager->persist($managerUser);

        $user = new User();
        $user->setEmail("user@user.com");
        // * on donne le mot de passe hashé
        // mdp : user
        $user->setPassword('$2y$13$J9VkB737ouoPOiH0oTGNQOlvqxZ6Hz95mZiubq/kFzgJ2B7nt608m');
        $user->setRoles(['ROLE_USER']);
        $user->setFirstname("user");
        $user->setLastname("user");

        $manager->persist($user);

        // =======================================================
        // TODO : créer 10 Genres
        // =======================================================
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

        // =======================================================
        // TODO : créer les 2 types : film et série
        // =======================================================
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

        // =======================================================
        // TODO : 2000 person
        // =======================================================

        /** @var Person[] $allPerson */
        $allPerson = [];
        for ($i=0; $i < 1000; $i++) { 
            // 1. faire une nouvelle instance
            $newPerson = new Person();
            //2. remplir les prop
            // si on utilise le faker cinema, il faut rajouter un traitement pour séparer prénom / nom
            $actorFullName = $faker->actor();// Cate Blanchett
            $actorNames = explode(" ", $actorFullName);
            // ! JB aime pas l'utilisation de ce tableau sans vérifier que les index existe
            $newPerson->setFirstname($actorNames[0]);
            $newPerson->setLastname($actorNames[1]);

            // 3. demander la persitance
            $manager->persist($newPerson);

            // 4. pour les fixtures : un tableau avec toutes les personnes
            $allPerson[] = $newPerson;

        }

        // =======================================================
        // TODO : créer 10 film
        // =======================================================
        /** @var Movie[] $allMovies */
        $allMovies = [];
        for ($i=0; $i < 100; $i++) { 
            // 1. instance
            $newMovie = new Movie();
            // 2. prop
            // $defaultUrl = "https://amc-theatres-res.cloudinary.com/amc-cdn/static/images/fallbacks/DefaultOneSheetPoster.jpg";
            // $picsumSeededUrl = "https://picsum.photos/seed/radium".$i."/200/300";
            // $fakerPicsumSeededUrl = $faker->imageUrl(200,300, 'radium-' . $i);
            // $newMovie->setPoster($fakerPicsumSeededUrl);

            // 2.bis : les associations
            $randomType = $allTypes[mt_rand(0, count($allTypes)-1)];
            $newMovie->setType($randomType);

            // TODO utiliser le service que vous avez créé : OMDBAPI
            // * on décale la propriété title car avec le faker on veux différencier les titres            
            if ($randomType->getName() === "série"){
                $titleTvShow = $faker->tvShow();
                $contentTvShow = $this->omdbApi->fetch($titleTvShow);
                $newMovie->setTitle($titleTvShow);

                $posterTvShow = $contentTvShow->getPoster();
                $newMovie->setPoster($posterTvShow);


                $summaryTvShow = $contentTvShow->getPlot();
                $newMovie->setSummary($summaryTvShow);

                $countryTvShow = $contentTvShow->getCountry();
                $newMovie->setCountry($countryTvShow);
            } else {
                $titleMovie = $faker->movie();
                $contentMovie = $this->omdbApi->fetch($titleMovie);
                $newMovie->setTitle($titleMovie);

                $posterMovie = $contentMovie->getPoster();
                $newMovie->setPoster($posterMovie);

                $summaryMovie = $contentMovie->getPlot();
                $newMovie->setSummary($summaryMovie);

                $countryMovie = $contentMovie->getCountry();
                $newMovie->setCountry($countryMovie);
            }

            $newMovie->setDuration(mt_rand(10, 360));
            $newMovie->setRating(mt_rand(0,50) / 10);

            $newMovie->setSynopsis($fakerFr->realText(200,2));
            // ? https://www.php.net/manual/fr/datetime.construct.php
            $newMovie->setReleaseDate(new DateTime($faker->date()));

            // 3. persist
            $manager->persist($newMovie);

            // 4. tableau de fixtures
            $allMovies[] = $newMovie;
        }


        // =======================================================
        // TODO : création de casting : il nous faut les objets Person ET les objets Movie
        // =======================================================
        // Pour chaque film, je veux entre 3 et 5 casting
        foreach ($allMovies as $movie) {
            //random nb casting
            $randomNbCasting = mt_rand(3,5);
            for ($i=1; $i <= $randomNbCasting; $i++) { 
                // 1 .
                $newCasting = new Casting();
                // 2.   
                $newCasting->setRole($faker->character());
                $newCasting->setCreditOrder($i);
                // 2.b
                $newCasting->setMovie($movie);
                $randomPerson = $allPerson[mt_rand(0, count($allPerson)-1)];
                $newCasting->setPerson($randomPerson);
                //3. persist
                $manager->persist($newCasting);
            }
        }

        // =======================================================
        // TODO : association de Genre avec Movie : entre 3 et 5 genre par film
        // =======================================================

        foreach ($allMovies as $movie) {
            $randomNbGenre = mt_rand(1,3);
            for ($i=0; $i <= $randomNbGenre; $i++) { 
                // 1. je cherche un genre aléatoire
                $randomGenre = $allGenre[mt_rand(0, count($allGenre)-1)];
                // 2. je remplit l'association
                $movie->addGenre($randomGenre);
                // 3. pas de persist car les 2 objets (movie / genre) sont déjà connu de Doctrine
            }
        }

        // =======================================================
        // TODO : association de Season avec Movie : entre 3 et 10 Season par série
        // =======================================================
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

        // =======================================================
        // TODO : Créer entre 0 et 4 review par movie
        // =======================================================
        $reactions = ['cry', 'smile', 'dream', 'think', 'sleep'];
        $rating = [];
        foreach ($allMovies as $movie) {
            $randomNbReview = mt_rand(0, 5);
            
            for ($i=0; $i < $randomNbReview; $i++) {
                // 1. faire une nouvelle instance
                /** @var Review $newReview */
                $newReview = new Review();
                //2. remplir les prop
                $newReview->setUsername($faker->userName());
                $newReview->setEmail($faker->email());
                $newReview->setContent($fakerFr->realText(30, 1));
                $newReview->setRating($faker->numberBetween(1,5));
                // créer un nombre de réactions aléatoire entre 1 et 5
                $randomNbReaction = $faker->numberBetween(0, count($reactions) -1);
                $newReview->setReactions([$reactions[$randomNbReaction]]);
                $newReview->setWatchedAt(new DateTimeImmutable($faker->date()));

                // calcul rating moyen
                $rating[] = $newReview->getRating();
                $sum = array_sum($rating);
                $count = count($rating);
                // moyenne arrondie à 1 chiffre après virgule
                $average = round($sum/$count, 1);
                $movie->setRating($average);
                $newReview->setMovie($movie);

                // 3. demander la persitance
                $manager->persist($newReview);

            }
        }

        // * appeler la méthode flush
        // c'est ici que les requetes SQL sont exécutées
        $manager->flush();
    }
}
