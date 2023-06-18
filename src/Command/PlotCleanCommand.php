<?php

namespace App\Command;

use App\Repository\MovieRepository;
use App\Service\OmdbApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PlotCleanCommand extends Command
{
    private $omdbApiService;
    private $entityManager;
    private $movieRepository;

    public function __construct(OmdbApiService $omdbApiService, EntityManagerInterface $entityManager, MovieRepository $movieRepository)
    {
        $this->omdbApiService = $omdbApiService;
        $this->entityManager = $entityManager;
        $this->movieRepository = $movieRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:plot-clean')
            ->setDescription('Clean up plots for movies');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get all the movie from the Repository
        $movies = $this->movieRepository->findAll();

        foreach ($movies as $movie) {

            //Retrieve the synopsis from the OMDBApi for the current movie
            $plot = $this->omdbApiService->fetchPlot($movie);

            if ($plot !== null) {
                // Define the synopsis of the film with the synopsis retrieved from the OMDBApi
                $movie->setSynopsis($plot);

                // Split the synopsis into separate sentences
                $sentences = preg_split('/(?<=[.?!])\s+/', $plot, 2);
                $summary = isset($sentences[0]) ? $sentences[0] : '';

                // Define the summary of the movie with the first sentence
                $movie->setSummary($summary);

                // Save the changes to the database
                $this->entityManager->persist($movie);
                $this->entityManager->flush();
            }
        }

        // Display a message indicating that synopsis cleaning has been done for all movies
        $output->writeln('Synopsis cleaned for all movies.');

        return Command::SUCCESS;
    }
}
