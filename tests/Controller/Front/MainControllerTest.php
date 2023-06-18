<?php

namespace App\Tests\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHomeAnonyme(): void
    {
        // Create a "fake" client
        $client = static::createClient();

        // Make a request to the root of the site
        $crawler = $client->request('GET', '/');

        // Assert that the response is successful (status code 200)
        $this->assertResponseIsSuccessful();

        // Check that the login link is visible on the page
        $this->assertSelectorExists("a[href='/login']", "Le lien de connexion n'est pas visible");

        // Check that an anonymous user cannot access the favorites page
        $this->assertSelectorNotExists("a[href='/favoris']","Malgrès l'anonymat le lien des favoris s'affiche");

    }

    public function testHomeAdmin(): void
    {
        // Create a "fake" client
        $client = static::createClient();

        // Get the UserRepository
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Get a test user
        $testUser = $userRepository->findOneByEmail('admin@oclock.io');

        // Log in the test user
        $client->loginUser($testUser);

        // Make a request to the root of the site
        $crawler = $client->request('GET', '/');

        // Assert that the response is successful (status code 200)
        $this->assertResponseIsSuccessful();

        // Check that the admin link is visible on the page
        $this->assertSelectorExists("a[href='/back-office/film/']", "le lien d'admin n'est pas visible");


    }
}
