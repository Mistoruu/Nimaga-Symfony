<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // 1. Création des 5 Catégories
        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->word());
            $manager->persist($category);
            $categories[] = $category;
        }

        // 2. Création des 10 Utilisateurs
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName());
            $user->setEmail($faker->email());
            $manager->persist($user);
            $users[] = $user;
        }

        // 3. Création des 50 Articles
        for ($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence(mt_rand(3, 8)));
            $article->setContent($faker->text(200));
            $article->setPublished($faker->boolean());

            // On convertit la DateTime de Faker en DateTimeImmutable pour l'entité
            $date = $faker->dateTimeBetween('-2 years', 'now');
            $article->setCreatedAt(\DateTimeImmutable::createFromMutable($date));

            // On pioche un auteur et une catégorie au hasard dans nos tableaux d'objets
            $article->setAuthor($users[array_rand($users)]);
            $article->setCategory($categories[array_rand($categories)]);

            $manager->persist($article);
        }

        $manager->flush();
    }
}
