<?php

namespace App\Listener;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;

class ReviewListener{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * This method is called after a Review entity is persisted to the database.
     * It updates the rating of the associated Movie entity based on all the reviews.
     */
    public function updateRatingMovie(Review $review, PostPersistEventArgs $postPersistEventArgs){

        // Get the movie associated with the review
        $movie = $review->getMovie();

        // Calculate the sum of all ratings
        $allNotes = null;

        foreach($movie->getReviews() as $review){
            $allNotes += $review->getRating();
        }

        // Calculate the average rating by dividing the sum by the total number of reviews
        $rating = $allNotes / count($movie->getReviews());

        // Set the rounded average rating with one decimal place to the movie
        $movie->setRating(round($rating,1));

        // Persist the changes to the database
        $this->entityManager->flush();
        
    }
}