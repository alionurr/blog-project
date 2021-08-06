<?php

namespace App\Controller\Storefront;

use App\Controller\AbstractController;
use App\Service\Storefront\CommentService;

class CommentController extends AbstractController
{
    public function addCommentAction($blogId)
    {
        $id = $blogId;
        $comment = $this->getRequest()->get("comment");
        $username = $this->getRequest()->get("username");

        /** @var CommentService $commentService */
        $commentService = $this->get(CommentService::class);
        $commentService->addComment($id,$comment, $username);

        echo json_encode(['status' => 'success']);
    }
}