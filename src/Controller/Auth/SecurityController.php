<?php

namespace App\Controller\Auth;

use App\Form\LoginForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            return $this->redirectToRoute("home");
        }

        $error = $authenticationUtils->getLastAuthenticationError();


        $form = $this->createForm(LoginForm::class, [
            '_username' => $authenticationUtils->getLastUsername()
        ]);

        return $this->render('auth/login.html.twig', array(
            'error' => $error,
            'login_form' => $form->createView()
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \Exception("This page should not be reached.");
    }
}