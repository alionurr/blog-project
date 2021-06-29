<?php
namespace App\Controller;

class BlogController extends AbstractController
{
    public function indexAction()
    {
        echo "Merhaba";exit;
    }

    public function viewAction($slug)
    {
        echo "Merhaba " .$slug;exit;
    }

    public function updateAction($id, $slug)
    {
        echo "Merhaba " .$id . " -> slug:" .$slug;
    }

    public function notfoundAction()
    {
        echo "Bulunamadı";Exit;
    }
}