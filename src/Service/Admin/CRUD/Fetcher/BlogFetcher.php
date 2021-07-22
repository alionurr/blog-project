<?php

namespace App\Service\Admin\CRUD\Fetcher;

use App\Entity\Blog;
use App\Service\Admin\AbstractService;
use Doctrine\ORM\EntityManager;

class BlogFetcher extends AbstractService
{

    public function fetch()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
        $blogs = $entityManager->getRepository(Blog::class)->findAll();

        $blogData = array_map(function ($blog){
            /** @var Blog $blog */
            return [
                'id' => $blog->getId(),
                'title' => $blog->getTitle(),
                'content' => $blog->getContent(),
                'category' => $blog->getCategories()->count(),
                'author' => $blog->getAuthor(),
            ];
        },$blogs);

        header('Content-Type: application/json');
        echo json_encode($blogData);
    }

    /**
     * @param $id
     * @return object|null
     */
    public function fetchById($id): ?object
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
//        var_dump($entityManager->getRepository(Blog::class)->find($id));exit();
        return $entityManager->getRepository(Blog::class)->find($id);

    }
}