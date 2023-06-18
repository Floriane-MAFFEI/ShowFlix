<?php

namespace App\Tests\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();

        // Go to the login page
        $crawler = $client->request('GET', '/login');

        // Check that the response has a 200 status code
        $this->assertResponseIsSuccessful();

        // Fill out the form and submit it
        $crawler = $client->submitForm("Se connecter", [
            "_username" => "admin@gmail.io",
            "_password" => "admin"
        ]);

        // Follow the redirection
        $crawler = $client->followRedirect();
        // Check that I arrive on the home page
        $this->assertSelectorTextContains("h1","Films, séries TV et popcorn en illimité.");



    }
}
