<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get the authentication error, if any
        $error = $authenticationUtils->getLastAuthenticationError();

        // Get the last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Render the login template with the last username and error (if any)
        return $this->render('front/security/index.html.twig',[
            "last_username" => $lastUsername,
            "error" => $error
        ]);
    }

     /**
     * @Route("/logout", name="app_security_logout")
     */
    public function logout()
    {

    }
}
