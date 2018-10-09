<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/index_auth", name="index_auth")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function index_auth()
    {
        dump($this->getUser());

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Auth user controller',
        ]);
    }
}
