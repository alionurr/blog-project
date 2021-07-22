<?php

namespace App\Service\Admin\CRUD\Creator;

use App\Entity\Blog;
use App\Entity\Category;
use App\Service\Admin\AbstractService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class BlogCreator extends AbstractService
{
    public function create(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
//        var_dump($request->request->all());exit();

        $blog = new Blog();
        $blog->setTitle($request->request->get("title"));
        $blog->setContent($request->request->get("content"));
        $blog->setAuthor($_SESSION['adminName']);
        $blog->setStatus("false");
        $blog->setCreatedAt(new \DateTime());
        $blog->setUpdatedAt(new \DateTime());

        $categoryIds = $request->request->get('categories');

        foreach ($categoryIds as $id) {
            /** @var Category $category */
            $category = $entityManager->getRepository(Category::class)->find($id);
//            var_dump($category);exit();
            $blog->addCategory($category);
        }

        try {
            $entityManager->persist($blog);
            $entityManager->flush($blog);
        } catch (ORMException $e) {
            echo $e->getMessage();exit();
        }
    }
}