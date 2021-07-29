<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Service\Admin\CRUD\Creator\BlogCreator;
use App\Service\Admin\CRUD\Deleter\BlogDeleter;
use App\Service\Admin\CRUD\Fetcher\BlogFetcher;
use App\Service\Admin\CRUD\Fetcher\CategoryFetcher;
use App\Service\Admin\CRUD\Updater\BlogUpdater;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    public function getAction()
    {
        /** @var BlogFetcher $blogFetcher */
        $blogFetcher = $this->get(BlogFetcher::class);
        $blogFetcher->fetch();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailAction($id)
    {
        /** @var BlogFetcher $fetchBlogById */
        $fetchBlogById = $this->get(BlogFetcher::class);
        $blog = $fetchBlogById->fetchById($id);
//        var_dump($blog);exit();
        return $this->get('twig')->render('admin/detail.html.twig', ['blog' => $blog]);
    }

    /**
     * @return RedirectResponse
     */
    public function addAction(): RedirectResponse
    {
//        var_dump($request);exit();
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST) {
            /** @var CategoryFetcher $categoryFetcher */
            $categoryFetcher = $this->get(CategoryFetcher::class);
            $categories = $categoryFetcher->fetch();
            echo $this->get('twig')->render('admin/addblog.html.twig', ['categories' => $categories]);
            exit();
        }

        /** @var BlogCreator $blogCreator */
        $blogCreator = $this->get(BlogCreator::class);
//        var_dump($this->getRequest()->request->get('categories'));exit();
        $blogCreator->create($this->getRequest());
        return new RedirectResponse("/admin/dashboard");
    }

    /**
     * @param $id
     */
    public function deleteAction($id)
    {
        /** @var BlogDeleter $blogDeleter */
        $blogDeleter = $this->get(BlogDeleter::class);
        $blogDeleter->delete($id);

    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function updateAction($id): RedirectResponse
    {
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST)
        {
            /** @var BlogFetcher $getBlogById */
            $getBlogById = $this->get(BlogFetcher::class);
            $foundBlog = $getBlogById->fetchById($id);

            /** @var CategoryFetcher $getCategories */
            $getCategories = $this->get(CategoryFetcher::class);
            $categories = $getCategories->fetch();
            echo $this->get('twig')->render('admin/update.html.twig', ['blog' => $foundBlog, 'categories' => $categories]);
            exit();
        }
//        var_dump($id);exit();
        /** @var BlogUpdater $blogUpdate */
        $blogUpdate = $this->get(BlogUpdater::class);
        $blogUpdate->update($id, $this->getRequest());

        return new RedirectResponse("/admin/dashboard");
    }
}