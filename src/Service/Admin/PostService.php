<?php


namespace App\Service\Admin;

use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Blog;

class PostService extends AbstractService
{
    /**
     * @param Request $request
     */
    public function addPost(Request $request)
    {

        $entityManager = $this->getEntityManager();
//        var_dump($request->request->all());exit();
        $blog = new Blog();
        $blog->setTitle($request->request->get("title"));
        $blog->setContent($request->request->get("content"));
        $blog->setAuthor($_SESSION['adminName']);
        $blog->setStatus("false");
        $blog->setCreatedAt(new \DateTime());
        $blog->setUpdatedAt(new \DateTime());

        try {
            $entityManager->persist($blog);
            $entityManager->flush($blog);
        } catch (ORMException $e) {
            echo $e->getMessage();exit();
        }


    }

}