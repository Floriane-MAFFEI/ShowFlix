<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    /**
     * Display the form for adding a review to a movie and proccess it
     * 
     * @Route("/film-serie/{id}/critique/ajouter", name="app_review_add")
     */
    public function add(Movie $movie, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create a new Review instance
        $review = new Review;

        // Create the form for the Review
        $form = $this->createForm(ReviewType::class,$review);

        // Handle the HTTP request and populate the Review object if the form was submitted
        $form->handleRequest($request);

        // Check if the form was submitted and is valid
        if ($form->isSubmitted() && $form->isValid()) {

            // Associate the Review with the Movie
            $review->setMovie($movie);
            
            /// Persist the Review entity to specify that it should be saved in the database
            $entityManager->persist($review);

            // Flush the changes to the database, i.e., save the persisted objects
            $entityManager->flush();

            // Flash messages are one-time messages stored in the session
            $this->addFlash("success", "Commentaire bien ajouté");

            // Redirect to the movie page with the added comment
            return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
        }

        // Render the form template with the form and movie data
        return $this->renderForm('front/review/form.html.twig',[
            "form" => $form,
            "movie" => $movie
        ]);
    }
}
