<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Repository\CastingRepository;
use App\Repository\ReviewRepository;
use App\Repository\SeasonRepository;
use App\Service\OmdbApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * Display a single movie
     *
     * @param int $id id of the movie
     *
     * @Route("/film-serie/{id}", name="app_movie_show", requirements={"id"="\d+"})
     */
    public function show(OmdbApiService $omdb, Movie $movie,CastingRepository $castingRepository, ReviewRepository $reviewRepository): Response
    {
        // Get the castings for the movie
        $castings = $castingRepository->findAllJoinedToPersonByMovie($movie);

        // Get the reviews for the movie
        $reviews = $reviewRepository->findBy(["movie" => $movie],["watchedAt" => "DESC"]);

        return $this->render('front/movie/show.html.twig',[
            "movie" => $movie,
            "castings" => $castings,
            "reviews" => $reviews
        ]);
    }

    /**
     * Display all movies or by search
     * 
     * 
     * @Route("/film-serie", name="app_movie_list")
     */
    public function list(EntityManagerInterface $entityManager,Request $request): Response
    {
        // Get all movies or search movies by keyword
       $movies = $entityManager->getRepository(Movie::class)->findAllOrderByTitleSearch($request->get("search"));

       return $this->render('front/movie/list.html.twig',[
            "movies" => $movies
        ]);
    }
}
