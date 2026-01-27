<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name: 'app_portfolio')]
    public function index(): Response
    {
        return $this->render('portfolio/index.html.twig');
    }

    #[Route('/portfolio/projets', name: 'portfolio_projets')]
    public function projects(): Response
    {
        return $this->render('portfolio/projets.html.twig');
    }

    #[Route('/portfolio/cv', name: 'portfolio_CV')]
    public function cv(): Response
    {
        return $this->render('portfolio/cv.html.twig');
    }

    #[Route('/portfolio/contact', name: 'portfolio_contact')]
    public function contact(): Response
    {
        return $this->render('portfolio/contact.html.twig');
    }
}
