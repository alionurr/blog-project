<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class BlogRepository extends EntityRepository
{
    /**
     * @param $value
     * @return mixed
     */
    public function searchByValue($value)
    {
        return $this->createQueryBuilder("b")
            ->where("b.title LIKE :val")
            ->orWhere("b.content LIKE :val")
            ->setParameter("val", "%".$value."%")
            ->getQuery()
            ->getResult();
    }
}