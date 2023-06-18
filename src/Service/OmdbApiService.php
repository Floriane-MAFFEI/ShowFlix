<?php

namespace App\Service;

use App\Entity\Movie;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiService{

    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        // Inject the HTTP client into the service
        $this->client = $client;

        // Configure the API key using the .env file
        // -Declare the parameter in service.yaml and populate it in the .env file
        $this->apiKey = $apiKey;
    }

    /**
     * Fetch a movie from the OmdbApi
     *
     * @param Movie $movie An instance of a movie
     * @return array The response content from the API as an array
     */
    public function fetch(Movie $movie){

        // Make an API request
        $response = $this->client->request(
            // First parameter is the HTTP method
            'GET',
            // The base URL of the API
            'http://www.omdbapi.com/',
            [
                // URL parameters
                "query" => [
                    "apikey" => $this->apiKey,
                    "t" => $movie->getTitle()
                    ]
            ]
            
        );

        // Convert the response content to an array
        $content = $response->toArray();

        return $content;
    }


    /**
     * Get a poster for a movie from omdbapi
     * 
     * @param Movie $movie an instance of a movie
     * 
     * @return string|null url of a poster or null if not found
     */
    public function fetchPoster(Movie $movie){

        // Reuse the code above to fetch the movie from the API
        $movieFromApi = $this->fetch($movie);

        // Check if the API response contains a poster
        if(!array_key_exists("Poster", $movieFromApi)){
            return null;
        }

        // If yes, return the poster URL
        return $movieFromApi["Poster"];

    }

    /**
     * Fetch the plot for a movie from the OmdbApi
     *
     * @param Movie $movie An instance of a movie
     * @return string|null The plot of the movie or null if not found
     */
    public function fetchPlot(Movie $movie)
    {
        // Make an API request to fetch the movie
        $response = $this->client->request(
            'GET',
            'http://www.omdbapi.com/',
            [
                'query' => [
                    'apikey' => $this->apiKey,
                    't' => $movie->getTitle()
                ]
            ]
        );

        // Convert the response content to an array
        $content = $response->toArray();

        // Check if the API response contains the plot
        if (!array_key_exists('Plot', $content)) {
            return null;
        }

        // If yes, return the plot
        return $content['Plot'];
    }


}