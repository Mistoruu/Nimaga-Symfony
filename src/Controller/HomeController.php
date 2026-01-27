<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'page_name' => 'home',
            'lastname' => 'Maillé',
            'firstname' => 'Eliott',
            'date' => date('d.m.Y'),

        ]);
    }
    #[Route('/home/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig', [
            'controller_name' => 'MainController',
            'page_name' => 'about',
        ]);
    }

    #[Route('/home/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'MainController',
            'page_name' => 'contact',
        ]);
    }
    #[Route('/home/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response
    {
        return $this->render('home/hello.html.twig', [
            'name' => $name,
        ]);
    }
}
