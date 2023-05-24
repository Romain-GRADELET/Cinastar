<?php

namespace App\Tests\Service;

use App\Services\OmdbApi;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OmdbApiTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());

        // TODO tester le service OmdbApi
        // 1. on doit récupérer notre service
        // on est pas dans symfony, on est dans le framework de test
        // on a donc pas l'injection de dépendance
        // on va donc utiliser les raccourcies fournit par symfony à PHPUnit (framework de test)
        // * on demande au conteneur de services de nous fournir notre service
        /** @var OmdbApi $omdbApi */
        $omdbApi = static::getContainer()->get(OmdbApi::class);

        $infosOdmb = $omdbApi->fetch("Finding Nemo");
        $posterExpected = "https://m.media-amazon.com/images/M/MV5BZjMxYzBiNjUtZDliNC00MDAyLTg3N2QtOWNjNmNhZGQzNDg5XkEyXkFqcGdeQXVyNjE2MjQwNjc@._V1_SX300.jpg";

        $this->assertEquals($posterExpected, $infosOdmb['Poster']);
        // ! "http://www.omdbapi.com/?t=Stranger%20Things&apiKey=xxxxx".
        // * il faut bien renseigner la clé dans le .env.test

        $infosOdmb = $omdbApi->fetch("aaaaaaaa");
        $expected = "Movie not found!";
        $this->assertEquals($expected, $infosOdmb['Error']);
        

    }
}
