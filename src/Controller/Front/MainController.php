<?php
// src/Controller/LuckyController.php
namespace App\Controller\Front;

use App\Entity\Movie;
use App\Service\OmdbApiService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Display the homepage
     * 
     * @Route("/", name="app_main_home")
     * 
     * @return Response object response 
     */
    public function home(EntityManagerInterface $entityManager): Response
    {
        // Retrieve the repository for the Movie entity from the entity manager
        $movies = $entityManager->getRepository(Movie::class)->findAllOrderByDate();

        return $this->render("front/main/home.html.twig",[
            "movies" => $movies
        ]);
    }
}