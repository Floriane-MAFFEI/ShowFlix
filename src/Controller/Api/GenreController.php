<?php

namespace App\Controller\Api;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * endpoint for all genres
     * 
     * @Route("/api/genres", name="app_api_genre_getGenres", methods={"GET"})
     */
    public function getGenres(GenreRepository $genreRepository): JsonResponse
    {
        // We retrieve all genres
        $genres = $genreRepository->findAll();

        // I retrieve all genres with a 200 status code
        return $this->json($genres, Response::HTTP_OK, [],["groups" => "genres"]);
    }

    /**
     * endpoint for movies of a specific genres
     * 
     * @Route("/api/genres/{id}/movies", name="app_api_genre_getMoviesByGenres", methods={"GET"})
     */
    public function getMoviesByGenres(Genre $genre = null): JsonResponse
    {
        // Check if the gender exists
        if(!$genre){
            // Return a JSON response with an error message and an HTTP 404 (Not Found) status code
            return $this->json(["error" => "Genre inexistant"], Response::HTTP_NOT_FOUND);
        }

        // Retrieve the movies associated with the genre
        $movies = $genre->getMovies();

        // I retrieve the genre retrieved with a 200 status code
        // Movies will be serialized using the "movies" serialization group
        return $this->json($movies, Response::HTTP_OK, [], ["groups" => "movies"]);
    }
}
