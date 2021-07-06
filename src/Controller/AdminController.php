<?php


namespace App\Controller;


use App\Service\Admin\CategoryService;
use App\Service\Admin\PostService;
use App\Service\Admin\SecurityService;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{

    public function indexAction()
    {
        echo $this->get('twig')->render('dashboard.html.twig');
    }

    /**
     * @return RedirectResponse|void
     * @throws Exception
     */
    public function signUpAction()
    {
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST) {
            echo $this->get('twig')->render('register.html.twig');
        }
        /** @var SecurityService $securityService */
        $securityService = $this->get(SecurityService::class);
        $securityService->register($this->getRequest());
        return new RedirectResponse("/admin/loginAction");
    }

    /**
     * @return RedirectResponse|void
     */
    public function loginAction()
    {
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST) {
            echo $this->get('twig')->render('login.html.twig');
            exit();
        }
//        $validator = "email, password";
        /** @var SecurityService $securityService */
        $securityService = $this->get(SecurityService::class);
        $securityService->login($this->getRequest());
        if (isset($_SESSION['adminName'])) {
            return new RedirectResponse("/admin/dashboard");
        }
        return new RedirectResponse("/admin/login");
    }


    public function logoutAction()
    {
        unset($_SESSION['adminName']);
        return new RedirectResponse("/admin/login");
    }


    public function addPostAction()
    {
//        var_dump($request);exit();
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST) {
            echo $this->get('twig')->render('addpost.html.twig');
            exit();
        }

        $entityManager = $this->getEntityManager();
        /** @var PostService $postService */
        $postService = $this->get(PostService::class);
        $postService->addPost($this->getRequest());

        return new RedirectResponse("/admin/dashboard");

    }

    public function addCategoryAction()
    {
//        echo "ali";
        $entityManager = $this->getEntityManager();
        /** @var CategoryService $categoryService */
        $categoryService = $this->get(CategoryService::class);
        $categoryService->addCategory($this->getRequest());
        return new RedirectResponse("/admin/dashboard");
    }
}