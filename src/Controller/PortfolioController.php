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
    public function projets(): Response
    {
        $projects = [
            [
                'title' => 'Participation GameJam',
                'category' => 'Game Jam',
                'url' => 'https://mistoru.itch.io/dobrazill',
                'url_label' => 'Voir la page itch.io',
                'description' => "Développement intensif d'un jeu vidéo réalisé en un week-end lors d'un événement collaboratif. Ce projet a nécessité une réactivité forte et une excellente gestion des priorités.",
                'points' => [
                    'Conception et implémentation des mécaniques de gameplay principales.',
                    "Travail d'équipe en flux tendu avec des graphistes et sound designers.",
                    'Optimisation des ressources pour garantir la fluidité sur navigateur.'
                ],
                'techs' => ['Godot', 'C#', 'Game Design', 'Aseprite'],
                'badge' => null,
            ],
            [
                'title' => 'Automatisation de tâches',
                'category' => 'Python',
                'url' => 'https://github.com/Mistoruu/Dokkan-EZA-Automation',
                'url_label' => 'Voir le Repo',
                'description' => "Conception d'une suite de scripts Python dédiés à l'automatisation de complétion de niveau de type 'EZA' sur le jeu Dragon Ball Z: Dokkan Battle !",
                'points' => [
                    'Automatisation de la complétion',
                    'CLI basique'
                ],
                'techs' => ['Python 3', 'Pyautogui', 'Automation'],
                'badge' => null,
            ],
            [
                'title' => 'Projet de BTS SIO',
                'category' => 'BTS SIO',
                'url' => 'https://github.com/Mistoruu/E6-Leger',
                'url_label' => 'Voir le Repo',
                'description' => "Développement d'un site web e-commerce répondant aux exigences d'un cahier des charges professionnel dans le cadre du diplôme BTS SIO.",
                'points' => [
                    'Modélisation rigoureuse de la base de données (UML, Merise).',
                    "Implémentation d'un système d'authentification (RBAC).",
                    'Génération automatique de rapports et de documents PDF.'
                ],
                'techs' => ['PHP', 'MySQL'],
                'badge' => null,
            ],
        ];

        return $this->render('portfolio/projets.html.twig', [
            'projects' => $projects,
        ]);
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
