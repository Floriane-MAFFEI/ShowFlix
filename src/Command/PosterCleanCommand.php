<?php

namespace App\Command;

use App\Entity\Movie;
use App\Service\OmdbApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PosterCleanCommand extends Command
{
    protected static $defaultName = 'app:poster-clean';
    protected static $defaultDescription = 'Replace broken image link from movies';

    private $entityManager;
    private $omdbApiService;

    public function __construct(EntityManagerInterface $entityManager, OmdbApiService $omdbApiService)
    {
        $this->entityManager = $entityManager;
        $this->omdbApiService = $omdbApiService;

        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Create an instance of SymfonyStyle to manage the interaction with the console
        $io = new SymfonyStyle($input, $output);
        $io->title('Démarrage du scann de vos posters');
        $io->progressStart(100);

        // Retrieve all movies from the database
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();

        foreach ($movies as $movie) {
            // Get the new poster from the OMDB API for the current movie
            $newPoster = $this->omdbApiService->fetchPoster($movie);
            // If a new poster is available in the API, replace it for the movie
            if($newPoster){
                $movie->setPoster($newPoster);
            }
        }
        
        $io->progressAdvance(100);
        $io->progressFinish();


        // Save the changes
        $this->entityManager->flush();

        // Display a success message indicating that the posters have been updated
        $io->success("Les posters ont été mis à jour");


        return Command::SUCCESS;
    }
}
