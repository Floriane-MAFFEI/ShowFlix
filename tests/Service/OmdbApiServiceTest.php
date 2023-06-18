<?php

namespace App\Tests\Service;

use App\Entity\Movie;
use App\Service\OmdbApiService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OmdbApiServiceTest extends KernelTestCase
{
    private const TEST_CASES = [
        "dikkenek",
        "kaboom",
        "Mais où est donc passée la 7ème compagnie",
        "match point"
    ];

    public function testFetch(): void
    {
        // Boot the kernel
        $kernel = self::bootKernel();

        // (2) Get the service container from the kernel
        $container = static::getContainer();

        // (3) Get the service we are interested in
        $omdbApiService = $container->get(OmdbApiService::class);

        foreach(self::TEST_CASES as $title){
            // For my API, the fetch method requires a Movie instance
            // Create a Movie with just the title for testing
            $movie = new Movie();
            $movie->setTitle($title);
            // Fetch the movie
            $result = $omdbApiService->fetch($movie);

            // Check if we get an array
            $this->assertIsArray($result);

            // Check that the array does not contain the "Error" key
            $this->assertArrayNotHasKey("Error",$result, "Un des fetch renvois un tableau avec une erreur");

            // Check if the array has a movie title
            $this->assertArrayHasKey("Title",$result);

            // Check if the movie title in the array matches the expected movie title
            $this->assertEqualsIgnoringCase($title,$result["Title"]);
        }


    }
}
