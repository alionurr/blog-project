<?php

namespace App\Controller\Storefront;

use App\Controller\AbstractController;
use App\Entity\Category;
use Doctrine\ORM\EntityManager;

class CategoryController extends AbstractController
{
    public function getAction($slug)
    {
//        echo $slug;
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();

        /** @var Category $categoryName */
        $categoryName = $entityManager->getRepository(Category::class)->findOneBy(['slug' => $slug]);
//        var_dump($relatedBlogs);exit();
        $relatedBlogs = $categoryName->getBlogs();
        echo $this->get('twig')->render('storefront/category.html.twig', ['blogs' => $relatedBlogs]);

    }
}