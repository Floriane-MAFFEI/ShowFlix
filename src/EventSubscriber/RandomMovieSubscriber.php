<?php

namespace App\EventSubscriber;

use App\Repository\MovieRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class RandomMovieSubscriber implements EventSubscriberInterface
{
    private $movieRepository;
    private $twig;

    public function __construct(MovieRepository $movieRepository, Environment $twig){

        $this->movieRepository = $movieRepository;
        $this->twig = $twig;
    }

    /**
     * This method is called when the kernel is about to call a controller.
     * It retrieves a random movie  and adds it as a global variable to Twig.
     */
    public function onKernelController(ControllerEvent $event): void
    {

        // Retrieve a random movie from the repository
        $randomMovie = $this->movieRepository->findRandomMovie();

        // Add the randomMovie as a global variable to Twig
        $this->twig->addGlobal("randomMovie", $randomMovie);

       
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController'
        ];
    }
}
