<?php

namespace App\Tests\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainTest extends WebTestCase
{
    public function testSomething(): void
    {
        // 1. création client HTTP
        $client = static::createClient();
        // 2. création et exécution requete HTTP
        // GET /
        $crawler = $client->request('GET', '/');

        // code de retour == 200 ?
        $this->assertResponseIsSuccessful();
        // la page contient une balise h1 avec le texte dedans ?
        $this->assertSelectorTextContains('h1', 'Films, séries TV et popcorn en illimité.');
    }
}
