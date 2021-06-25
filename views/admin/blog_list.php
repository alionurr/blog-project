<?php
require_once __DIR__ . '/../../config.php';
use Blog\Blog;


    $blogs = $entityManager->getRepository(Blog::class)->findAll();

    $blogData = array_map(function($blog){
        /** @var Blog $blog */
        return [
            'id' => $blog->getId(),
            'author' => $blog->getAuthor(),
            'title' => $blog->getTitle(),
            'excerpt' => $blog->getExcerpt(),
            'status' => $blog->getStatus(),
            'category' => $blog->getCategories()->count()
        ];
    }, $blogs);



header('Content-Type: application/json');

echo json_encode($blogData);

