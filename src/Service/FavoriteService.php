<?php

namespace App\Service;

use App\Entity\Movie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavoriteService{

    private $request;
    private $maxFav;

    public function __construct(RequestStack $request, int $maxFav)
    {
        $this->request = $request;
        $this->maxFav = $maxFav;
        
    }

    /**
     * Get all favorite movies from the session
     *
     * @return array|null
     */
    public function getAll(){

        // Retrieve the session
        $session = $this->request->getSession();

        // Get the favorite movies from the session
        $movies = $session->get("favorite");

        // Return the favorite movies
        return $movies;

    }

    /**
     * toggle a movie in the favorite session
     *
     * @param Movie $movie an instance of movie
     *
     * @return bool
     */
    public function toggle(Movie $movie){

        // Get the ID of the movie
        $idMovie = $movie->getId();

        // ! Retrieve the session object
        $session = $this->request->getSession();

        // ! Retrieve the content of the "favorite" session variable
        $favorite = $session->get("favorite", []);

        // ! If the movie is already in the favorites, remove it
        if(isset($favorite[$idMovie])){

            unset($favorite[$idMovie]);
        }else{
            // ! Otherwise, add the movie to the favorites
            if(count($favorite) >= $this->maxFav){
                // If the maximum number of favorites is reached, prevent adding
                return false;
            }
            // The return before adding blocks the addition based on the maximum number of favorites
            $favorite[$idMovie] = $movie;
        }

        // ! Save the updated array with the movie added/removed to the session
        $session->set("favorite", $favorite);

        return true;

    }

    /**
     * Remove all movies from the favorite session
     *
     * @return bool
     */
    public function empty(){

        // Retrieve the session
        $session = $this->request->getSession();
        // Remove the "favorite" session variable
        $session->remove("favorite");

        return true;
    }

}