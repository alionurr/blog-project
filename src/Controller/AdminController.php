<?php


namespace App\Controller;


use App\Service\Admin\CategoryService;
use App\Service\Admin\PostService;
use App\Service\Admin\SecurityService;
use App\Validation\AdminLoginValidator;
use App\Validation\AdminRegisterValidator;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AbstractController
{

    public function indexAction()
    {
        echo $this->get('twig')->render('dashboard.html.twig');
    }

    /**
     * @return RedirectResponse|null
     * @throws Exception
     */
    public function signUpAction(): ?RedirectResponse
    {
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST) {
            $errorParameters = [];
            if (isset($_SESSION['errors'])){
                $errorParameters = $_SESSION['errors'];
                unset($_SESSION['errors']);
            }
            echo $this->get('twig')->render('register.html.twig', ['errors' => $errorParameters]);
        }

        $validator = new AdminRegisterValidator($this->getRequest());
        $validator->validateForRegister();
        if (!empty($validator->errors)){
            $_SESSION['errors'] = $validator->errors;
            return new RedirectResponse('/admin/sign-up');
        }

        /** @var SecurityService $securityService */
        $securityService = $this->get(SecurityService::class);
        $securityService->register($validator->name,$validator->email,$validator->password,$validator->confirmPassword);
        return new RedirectResponse("/admin/login");
    }

    /**
     * @return RedirectResponse|null
     */
    public function loginAction(): ?RedirectResponse
    {
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST) {
            $errorParameters = [];
            if (isset($_SESSION['errors'])) {
                $errorParameters = $_SESSION['errors'];
                unset($_SESSION['errors']);
            }
            echo $this->get('twig')->render('login.html.twig', ['errors' => $errorParameters]);
            exit();
        }
        $validator = new AdminLoginValidator($this->getRequest());
        $validator->validateForLogin();
        if (!empty($validator->errors)) {
            $_SESSION['errors'] = $validator->errors;
            return new RedirectResponse('/admin/login');
        }

        /** @var SecurityService $securityService */
        $securityService = $this->get(SecurityService::class);
        $securityService->login($validator->email,$validator->password);

        if (isset($_SESSION['adminName'])) {
            return new RedirectResponse("/admin/dashboard");
        }
        return new RedirectResponse("/admin/login");
    }

    /**
     * @return RedirectResponse
     */
    public function logoutAction(): RedirectResponse
    {
        unset($_SESSION['adminName']);
        return new RedirectResponse("/admin/login");
    }

    /**
     * @return RedirectResponse
     */
    public function addPostAction(): RedirectResponse
    {
//        var_dump($request);exit();
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST) {
            echo $this->get('twig')->render('addpost.html.twig');
            exit();
        }

        /** @var PostService $postService */
        $postService = $this->get(PostService::class);
        $postService->addPost($this->getRequest());

        return new RedirectResponse("/admin/dashboard");

    }

    /**
     * @return RedirectResponse|null
     */
    public function addCategoryAction(): ?RedirectResponse
    {

        /** @var CategoryService $categoryService */
        $categoryService = $this->get(CategoryService::class);
        $categoryService->addCategory($this->getRequest());
        return new RedirectResponse("/admin/dashboard");
    }

}