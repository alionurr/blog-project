<?php


namespace App\Service\Admin;

require_once __DIR__.'/../../../Slugger.php';

use App\Entity\Category;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class CategoryService extends AbstractService
{
    /**
     * @param Request $request
     */
    public function addCategory(Request $request)
    {
        $entityManager = $this->getEntityManager();
//        var_dump($request->request->all());
        $category = new Category();
        $category->setName($request->request->get("category"));
        $category->setSlug(\Slugger::createSlug($request->request->get("category")));
//        var_dump(\Slugger::createSlug($request->request->get("category")));exit();
        try {
            $entityManager->persist($category);
            $entityManager->flush($category);
        } catch (ORMException $e) {
            echo $e->getMessage();exit();
        }
    }

}