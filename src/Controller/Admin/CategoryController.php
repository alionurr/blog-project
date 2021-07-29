<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Service\Admin\CRUD\Creator\CategoryCreator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CategoryController extends AbstractController
{
    /**
     * @return RedirectResponse|null
     */
    public function addAction(): ?RedirectResponse
    {
        /** @var CategoryCreator $categoryService */
        $categoryService = $this->get(CategoryCreator::class);
        $categoryService->create($this->getRequest());
        return new RedirectResponse("/admin/dashboard");
    }
}