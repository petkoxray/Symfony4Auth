<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Form\RegisterForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration", methods={"GET"})
     */
    public function registerAction(Request $request): Response
    {
        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            return $this->redirectToRoute("home");
        }

        $form = $this->createForm(RegisterForm::class);

        return $this->render('auth/register.html.twig', [
                'register_form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/register", name="user_register_process", methods={"POST"})
     */
    public function registerProcessAction(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            return $this->redirectToRoute("home");
        }

        $user = new User();
        $form = $this->createForm(RegisterForm::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'You have been registered successfully');
            return $this->redirectToRoute('home');
        }

        return $this->render('auth/register.html.twig', [
                'register_form' => $form->createView()
            ]
        );
    }
}
