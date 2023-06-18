<?php

namespace App\Listener;

use App\Entity\Movie;
use Symfony\Component\String\Slugger\SluggerInterface;

class MovieListener{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * This method is called when a Movie entity is being updated or created.
     * It takes the movie's title, slugifies it using the injected slugger, and sets the slug value on the movie entity.
     */
    public function slugifyTitle(Movie $movie){

        // Use the injected slugger to slugify the movie's title
        $movie->setSlug($this->slugger->slug($movie->getTitle()));
    }
}