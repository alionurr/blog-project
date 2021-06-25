<?php

namespace Blog;

use Doctrine\ORM\EntityRepository;

/**
 * Class BlogRepository
 * @package Blog
 */
class BlogRepository extends EntityRepository
{
    /**
     * @param $searchValue
     * @return int|mixed|string
     */
    public function searchBy($searchValue)
    {
        return $this->createQueryBuilder("b")
            ->where("b.title LIKE :val")
            ->orWhere("b.excerpt LIKE :val")
            ->orWhere("b.content LIKE :val")
            ->setParameter("val", "%".$searchValue."%")
            ->getQuery()
            ->getResult();
    }

    public function getTotalCountByParams()
    {
        return $this->_em->createQueryBuilder()
            ->select('COUNT(b.id) as count')
            ->from(Blog::class, 'b')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByPaginationParam($page, $limit)
    {
        return $this->_em->createQueryBuilder()
            ->select('b')
            ->from(Blog::class, 'b')
            ->setFirstResult($page)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}