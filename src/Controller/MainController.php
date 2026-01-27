<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'page_name' => 'main',
            'lastname' => 'Maillé',
            'firstname' => 'Eliott',
            'date' => date('d.m.Y'),

        ]);
    }
    #[Route('/main/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig', [
            'controller_name' => 'MainController',
            'page_name' => 'about',
        ]);
    }

    #[Route('/main/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
            'page_name' => 'contact',
        ]);
    }
    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response
    {
        return $this->render('main/hello.html.twig', [
            'name' => $name,
        ]);
    }
}
