<?php

namespace App\Service\Admin\CRUD\Deleter;

use App\Entity\Blog;
use App\Service\Admin\AbstractService;
use Doctrine\ORM\EntityManager;

class BlogDeleter extends AbstractService
{
    public function delete($id)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
        $blog = $entityManager->getRepository(Blog::class)->find($id);
//        var_dump($blog);exit();
        if($blog){
            $entityManager->remove($blog);
            $entityManager->flush();
        }
    }
}