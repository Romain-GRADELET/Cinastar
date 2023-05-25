<?php

namespace App\Tests\Back;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserAccessTest extends WebTestCase
{
    /**
     * test url
     *
     * @dataProvider getUrls
     * 
     * @param string $url
     */
    public function testBackForbidden($url, $email): void
    {
        $client = self::createClient();

        // Le Repo des Users
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère admin@admin.com
        $testUser = $userRepository->findOneByEmail($email);
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }


    /**
     * fournit TOUT les paramètres pour une function
     * 
     * @return array
     */
    public function getUrls()
    {
        yield ['/back/main', 'user@user.com'];
        yield ['/back/movie', 'user@user.com'];
        yield ['/back/casting/new', 'user@user.com'];
        yield ['/back/casting/new', 'manager@manager.com'];
 
    }
}
