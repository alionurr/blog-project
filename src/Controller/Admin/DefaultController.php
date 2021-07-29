<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function notfoundAction()
    {
        echo "Bulunamadı";Exit;
    }
}