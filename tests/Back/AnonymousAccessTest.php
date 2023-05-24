<?php

namespace App\Tests\Back;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnonymousAccessTest extends WebTestCase
{
    /**
     * Routes en GET pour Anonymous
     */
    public function testPageGetIsRedirect()
    {
        $client = self::createClient();
        $client->request('GET', '/back/main');

        $this->assertResponseRedirects();
    }
}




// // Le Repo des Users
// $userRepository = static::getContainer()->get(UserRepository::class);
// // On récupère admin@admin.com
// $testUser = $userRepository->findOneByEmail('admin@admin.com');
// // simulate $testUser being logged in
// $client->loginUser($testUser);