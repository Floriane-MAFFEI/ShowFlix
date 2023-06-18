<?php

namespace App\Controller\Api;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MovieController extends AbstractController
{
    /**
     * endpoint for all movies with infos of all relations
     * 
     * @Route("/api/movies", name="app_api_movie_getMovies", methods={"GET"})
     */
    public function getMovies(MovieRepository $movieRepository): JsonResponse
    {

        // We retrieve all movies
        $movies = $movieRepository->findAll();

        // I retrieve all movies with a 200 status code
        return $this->json($movies,Response::HTTP_OK,[], ["groups" => "movies"]);
    }

     /**
     * endpoint for a specific movie
     * 
     * @Route("/api/movies/{id}", name="app_api_movie_getMoviesById", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getMoviesById(Movie $movie): JsonResponse
    {

        // TODO gérer si le film n'existe pas

        return $this->json($movie,Response::HTTP_OK,[], ["groups" => "movies"]);
    }

    /**
     * endpoint for a random movie
     * 
     * @Route("/api/movies/random", name="app_api_movie_getRandom", methods={"GET"})
     */
    public function getRandom(MovieRepository $movieRepository): JsonResponse
    {

        // Retrieve a random movie from the repository
        $movie = $movieRepository->findRandomMovie();
         
        return $this->json($movie);
    }

      /**
     * endpoint for adding a movie
     * 
     * @Route("/api/movies", name="app_api_movie_postMovies", methods={"POST"})
     */
    public function postMovies(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        // Get the content of the request (the JSON)
        $data = $request->getContent();

        try {
            // Deserialize the JSON into a Movie entity using the injected Serializer
            $movie = $serializer->deserialize($data, Movie::class, "json");
        } catch (NotEncodableValueException $e) {
            // Return a JSON response indicating that the JSON is invalid
            return $this->json(["error" => "Invalid JSON"], Response::HTTP_BAD_REQUEST);
        }

        // Manually validate the entity since we don't have access to the isValid function of Symfony forms
        $errors = $validator->validate($movie);
        if (count($errors) > 0) {
            // Create an empty array to store the errors
            $dataErrors = [];

            // Loop through the errors
            foreach ($errors as $error) {
                // Create an index in the array for each field and list all the errors for that field in a sub-array
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }

            // Return a JSON response with the validation errors and a status code of 422 (Unprocessable Entity)
            return $this->json($dataErrors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Persist the movie in the database
        $entityManager->persist($movie);
        $entityManager->flush();

        // Provide the link to the created resource
        return $this->json(["creation successful"], Response::HTTP_CREATED, [
            "Location" => $this->generateUrl("app_api_movie_getMoviesById", ["id" => $movie->getId()])
        ]);
    }
}
