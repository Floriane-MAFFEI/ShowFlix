<?php

namespace App\Tests\Controller\Front;

use App\Entity\Movie;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FavoriteControllerTest extends WebTestCase
{
    private $client;
    private $testUser;
    CONST MOVID_ID = 1;

    public function setUp(): void{
        $this->client = static::createClient();

        // Get the UserRepository
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Get a test user
        $this->testUser = $userRepository->findOneByEmail('admin@oclock.io');

        // Log in the test user
        $this->client->loginUser($this->testUser);
    }

    public function testAdd(): void
    {
        // Make a GET request to add a movie to favorites
        $crawler = $this->client->request('GET', '/favoris/ajouter/'.self::MOVID_ID);

        // Assert that the response redirects to the favorites page
        $this->assertResponseRedirects('/favoris');

        // Verify that the flash message "Film ajouté aux favoris" is present
        $crawler = $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success:contains("Film ajouté aux favoris")');

        // Verify that the movie is present in the favorites list
        $this->assertSelectorExists('a[href="/favoris/supprimer/'.self::MOVID_ID.'"]');
    }

    public function testRemove(): void
    {
        // Add a movie to favorites
        $crawler = $this->client->request('GET', '/favoris/ajouter/'.self::MOVID_ID);
        $this->assertResponseRedirects('/favoris', Response::HTTP_FOUND);

        // Remove the movie from favorites
        $this->client->request('GET', '/favoris/supprimer/'.self::MOVID_ID);
        $this->assertResponseRedirects('/favoris', Response::HTTP_FOUND);

        // Verify that the flash message "Film supprimé des favoris" is present
        $crawler = $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-warning:contains("Film supprimé des favoris")');

        // Verify that the favorites list is empty
        $this->assertSelectorNotExists('a[href="/favoris/supprimer/'.self::MOVID_ID.'"]');
    }

    public function testRemoveAction()
    {
        // Add a movie to favorites
        $crawler = $this->client->request('GET', '/favoris/ajouter/'.self::MOVID_ID);
        $this->assertResponseRedirects('/favoris', Response::HTTP_FOUND);

        // Assert that the response redirects to the favorites page
        $this->assertResponseRedirects('/favoris');

        // Remove all movies from favorites
        $crawler = $this->client->request('GET', '/favoris/vider');
        $this->assertResponseRedirects('/favoris');

        // Verify that the flash message "Les favoris ont été vidés" is present
        $crawler = $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-warning:contains("Les favoris ont été vidé")');

        // Verify that the favorites list is empty
        $this->assertSelectorNotExists('.movie__poster');
    }
}
