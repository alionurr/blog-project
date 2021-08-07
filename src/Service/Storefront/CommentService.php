<?php

namespace App\Service\Storefront;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class CommentService extends AbstractService
{
    public function addComment($id, $content, $username)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();

        /** @var Blog $foundBlog */
        $blog = $entityManager->getRepository(Blog::class)->find(['id' => $id]);

        $comment = new Comment();
        $comment->setUsername($username);
        $comment->setContent($content);
        $comment->setBlog($blog);

        try {
            $entityManager->persist($comment);
            $entityManager->flush($comment);

            return $comment;
        } catch (ORMException $e) {
            echo $e->getMessage();exit();
        }
    }
}