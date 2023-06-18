<?php

namespace App\Tests\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReviewControllerTest extends WebTestCase
{
    const GOOD_REVIEW =  [
        "review[watchedAt]" => "2023-10-04",
        "review[username]" => "Floriane",
        "review[email]" => "flo@gmail.io",
        "review[content]" => "Ce texte doit faire plus de 100 caractère Ce texte doit faire plus de 100 caractèreCe texte doit faire plus de 100 caractèreCe texte doit faire plus de 100 caractère",
        "review[rating]" => 5,
        "review[reactions]" => ["rire"]
    ];
    const BAD_REVIEW =  [
        "review[watchedAt]" => "2023-10-04",
        "review[username]" => "Floriane",
        "review[email]" => "flo@gmail.io",
        "review[content]" => "pas assez gros texte :(",
        "review[rating]" => 5,
        "review[reactions]" => ["rire"]
    ];
    public function testSubmitReview(): void
    {
        $client = static::createClient();

        // Get the UserRepository
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Get a test user
        $testUser = $userRepository->findOneByEmail('admin@oclock.io');

        // Log in the test user
        $client->loginUser($testUser);

        // Go to the link for adding a review
        $client->request('GET', '/film-serie/1/critique/ajouter');

        // Check that the constraints block when the form is not properly filled out
        // Check that the submission works when the form is properly filled out
        $client->submitForm("Valider la critique",self::BAD_REVIEW);
        $this->assertEquals(422, $client->getResponse()->getStatusCode());

        // Check that the submission works when the form is properly filled out
        $client->submitForm("Valider la critique",self::GOOD_REVIEW);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

    }
}
