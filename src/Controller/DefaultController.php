<?php
namespace App\Controller;

use http\Env\Response;

class DefaultController extends AbstractController
{
    public function indexAction()
    {

//        $words = ['sky', 'mountain', 'falcon', 'forest', 'rock', 'blue'];
//        $sentence = 'today is a windy day';

//        echo $this->twig->render('first.html.twig', ['name' => 'John Doe', 'occupation' => 'gardener']);

        $users = [
            ['name' => 'John Doe', 'active' => true],
            ['name' => 'Lucy Smith', 'active' => false],
            ['name' => 'Peter Holcombe', 'active' => true],
            ['name' => 'Barry Collins', 'active' => false]
        ];

        echo $this->twig->render('first.html.twig',
            ['users' => $users]);

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