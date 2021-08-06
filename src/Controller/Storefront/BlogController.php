<?php

namespace App\Controller\Storefront;

use App\Controller\AbstractController;
use App\Entity\Blog;
use App\Entity\Category;
use App\Service\Storefront\BlogSearchService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BlogController extends AbstractController
{
    public function index()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
        /** @var Category $categories */
        $categories = $entityManager->getRepository(Category::class)->findAll();
        /** @var Blog $blogs */
        $blogs = $entityManager->getRepository(Blog::class)->findBy([],['id' => 'DESC']);
        echo $this->get('twig')->render('storefront/index.html.twig', ['blogs' => $blogs, 'categories' => $categories]);
    }

    /**
     * @param $id
     */
    public function detailAction($id)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
        /** @var Category $categories */
        $categories = $entityManager->getRepository(Category::class)->findAll();
        /** @var Blog $foundBlog */
        $foundBlog = $entityManager->getRepository(Blog::class)->find($id);
        echo $this->get('twig')->render('storefront/detail.html.twig', ['blog' => $foundBlog, 'categories' => $categories]);
    }

    public function searchAction()
    {
        $searchValue = $this->getRequest()->request->get('search');

        if (empty($searchValue)){
            return new RedirectResponse("/");
        }

        /** @var BlogSearchService $blogSearch */
        $blogSearch = $this->get(BlogSearchService::class);
        $searchResults = $blogSearch->search($searchValue);

        echo $this->get('twig')->render('storefront/search.html.twig', ['results' => $searchResults, 'searchValue' => $searchValue]);
    }


}