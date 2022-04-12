<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/liste-des-categories", name="category_list")
     */
    public function list(CategoryRepository $repo): Response
    {
        $categories = $repo->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/categorie/{slug}", name="category_show")
     */
    public function show(CategoryRepository $repo, string $slug): Response
    {
        $category = $repo->findOneBy(['slug' => $slug]);

        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }
}
