<?php


namespace App\Service\Admin\CRUD\Fetcher;


use App\Entity\Category;
use App\Service\AbstractService;

class CategoryFetcher extends AbstractService
{
    public function fetch(): array
    {
        $entityManager = $this->getEntityManager();
        //var_dump($categories);exit();
        return $entityManager->getRepository(Category::class)->findAll();
    }
}