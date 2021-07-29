<?php

namespace App\Service\Admin\CRUD\Updater;

use App\Entity\Blog;
use App\Entity\Category;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class BlogUpdater extends AbstractService
{
    /**
     * @param $id
     * @param Request $request
     */
    public function update($id, Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
        /** @var Blog $blog */
        $blog = $entityManager->getRepository(Blog::class)->find($id);
        $blog->setTitle($request->request->get('title'));
        $blog->setContent($request->request->get('content'));
        $blog->setAuthor($_SESSION['adminName']);
        $blog->setUpdatedAt(new \DateTime());

        $postCategoryIds = (array) $request->request->get('categories');
        $postCategories = $entityManager->getRepository(Category::class)->findById($postCategoryIds);

        $blogCategories = $blog->getCategories();

        /** @var Category $blogCategory */
        foreach ($blogCategories as $blogCategory) {
            if (!in_array($blogCategory->getId(), $postCategoryIds)){
                $blog->removeCategory($blogCategory);
            }
        }
        foreach ($postCategories as $postCategory) {
            $blog->addCategory($postCategory);
        }

        try {
            $entityManager->persist($blog);
            $entityManager->flush($blog);
        } catch (ORMException $e) {
            echo $e->getMessage();exit();
        }
    }
}