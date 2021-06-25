<?php

namespace Blog;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class CategoryRepository
 * @package Blog
 */
class CategoryRepository extends EntityRepository
{
    public function findByMostCount()
    {
        return $this->_em->createQueryBuilder()
            ->select('c')
            ->from(Category::class, 'c')
            ->innerJoin(BlogCategory::class, 'bc', Join::WITH, 'bc.category=c.id')
            ->innerJoin(Blog::class, 'b', Join::WITH, 'bc.blog=b.id')
            ->groupBy('c.id')
            ->orderBy('COUNT(b.id)', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}