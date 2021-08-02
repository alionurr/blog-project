<?php

namespace App\Service\Storefront;

use App\Entity\Blog;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class BlogSearchService extends AbstractService
{
    /**
     * @param $value
     * @return mixed
     */
    public function search($value)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
        return $entityManager->getRepository(Blog::class)->searchByValue($value);
    }
}