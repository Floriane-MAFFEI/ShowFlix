<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Service\FavoriteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    private $favoriteService;

    public function __construct(FavoriteService $favoriteService){
        $this->favoriteService = $favoriteService;
    }

    /**
     * display the list of favorite
     * 
     * @param Request $request the current request
     * 
     * @Route("/favoris", name="app_favorite_list")
     */
    public function list(): Response
    {

        // Call the favorite service to retrieve the favorites
        $movies = $this->favoriteService->getAll();

        return $this->render('front/favorite/list.html.twig',[
            "movies" => $movies
        ]);
    }

    /**
     * 
     * add a movie to the session
     * 
     * @param Request $request the current request object
     * @param Movie $movieModel model of movie
     * @param int $id id of the movie to add
     *
     * 
     * @Route("/favoris/ajouter/{id}", name="app_favorite_add",requirements={"id"="\d+"})
     */
    public function add(Movie $movie): Response
    {

        // Add a movie to the favorites
        if($this->favoriteService->toggle($movie)){
            // If adding returns true, display an message
            $this->addFlash("success", "Film ajouté aux favoris");

        }else{
            // If adding returns false, display an error message
            $this->addFlash("danger", "Nombre maximum de favoris atteint");
        }


        return $this->redirectToRoute("app_favorite_list");
    }


    /**
     * Empty all favorite in session
     * 
     * @param Request $request the current request
     * 
     * @Route("/favoris/vider", name="app_favorite_empty")
     */
    public function empty(): Response
    {

        $this->favoriteService->empty();
        $this->addFlash("warning", "Les favoris ont été vidé");

        return $this->redirectToRoute("app_favorite_list");
    }

    /**
     * delete a movie of the favorite session list
     * 
     * @param Request $request the current request
     * @param int $id id of the movie to delete
     * 
     * @Route("/favoris/supprimer/{id}", name="app_favorite_remove")
     */
    public function remove(Movie $movie): Response
    {
        $this->favoriteService->toggle($movie);

        $this->addFlash("warning", "Film supprimé des favoris");

        return $this->redirectToRoute("app_favorite_list");
    }

}
