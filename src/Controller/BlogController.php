<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlogController extends AbstractController
{
    private array $articles = [
        1 => [
            'titre' => 'Aventure au Japon',
            'continent' => 'Asie',
            'budget' => 'Haut',
            'description' => 'Découvrez le mélange entre tradition et modernité.',
            'paragraphe' => 'Du tumulte de Tokyo aux temples paisibles de Kyoto...',
            'auteur' => 'Alice Martin',
            'date' => '2024-03-10'
        ],
        2 => [
            'titre' => 'Roadtrip en Islande',
            'continent' => 'Europe',
            'budget' => 'Haut',
            'description' => 'Terre de glace et de feu.',
            'paragraphe' => 'Parcourir la route circulaire vous permettra de voir...',
            'auteur' => 'Jean Dupont',
            'date' => '2024-03-20'
        ],
        3 => [
            'titre' => 'Escapade au Maroc',
            'continent' => 'Afrique',
            'budget' => 'Bas',
            'description' => 'Les couleurs et les saveurs de Marrakech.',
            'paragraphe' => 'Perdez-vous dans les souks de la Médina...',
            'auteur' => 'Sonia Bernard',
            'date' => '2026-01-27'
        ],
    ];
    #[Route('/blog', name: 'blog_list')]
    public function index(): Response
    {

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $this->articles,
        ]);
    }
    #[Route('/blog/{id}', name: 'blog_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        if (!array_key_exists($id, $this->articles)) {
            throw $this->createNotFoundException("L'article n'existe pas.");
        }

        $article = $this->articles[$id];
        $article['date'] = new \DateTime($article['date']);
        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'controller_name' => 'BlogController',
        ]);
    }
}
