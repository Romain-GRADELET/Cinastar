<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Type;
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
        // TODO : créer 10 Genres
        $genres = [
            'horreur',
            'comique',
            'sf'
        ];
        // TODO : faire un foreach sur le tableau pour avoir des données plus réaliste


        for ($i=1; $i <= 10; $i++) { 
            // TODO on commence par en créer 1, puis on fait une boucle
            // * faire un new
            $newGenre = new Genre();

            // * remplir les propriétés
            $newGenre->setName("Genre #" . $i);

            // * appeler la méthode persist avec notre entité
            // on demande la persitance de l'objet
            $manager->persist($newGenre);
        }


        // TODO : créer les 2 types : film et série
        $types = [
            'film',
            'série',
        ];

        foreach ($types as $type ) { 
            // TODO on commence par en créer 1, puis on fait une boucle
            // * faire un new
            $newType = new Type();

            // * remplir les propriétés
            $newType->setName($type);

            // * appeler la méthode persist avec notre entité
            // on demande la persitance de l'objet
            $manager->persist($newType);
        }

        // * appeler la méthode flush
        // c'est ici que les requetes SQL sont exécutées
        $manager->flush();
    }
}
