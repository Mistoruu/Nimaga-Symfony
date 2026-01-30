<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/article')]
final class ArticleController extends AbstractController
{
    #[Route(name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository,PaginatorInterface $paginator,Request $request, CategoryRepository $categoryRepository): Response
    {
        $criteria = [
            'q'        => $request->query->get('q'),
            'category' => $request->query->get('category'),
        ];

        $query = $articleRepository->search($criteria);
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'criteria' => $criteria,
            'categories' => $categoryRepository->findCategories(),
            'title' => 'All articles'
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
    #[Route('/published', name: 'app_article_published', methods: ['GET'])]
    public function showPublished(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $articleRepository->findPublished();
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'title' => 'Published articles'
        ]);
    }
    #[Route('/recent', name: "app_article_recent", methods: ['GET'])]
    public function showRecent(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $articleRepository->findRecent();
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'title' => 'Recent articles'
        ]);
    }
    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/category/{categoryId}', name: 'app_article_by_category', methods: ['GET'], requirements: ['categoryId' => '\d+'])]
    public function showByCategory(ArticleRepository $articleRepository, $categoryId): Response
    {
        $articles = $articleRepository->findByCategory($categoryId);
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/author/{userId}', name: 'app_article_by_author', methods: ['GET'], requirements: ['userId' => '\d+'])]
    public function showByAuthor(ArticleRepository $articleRepository, $userId): Response
    {
        $articles = $articleRepository->findByAuthor($userId);
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

}

