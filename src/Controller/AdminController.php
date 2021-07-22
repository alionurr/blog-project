<?php


namespace App\Controller;


use App\Entity\Blog;
use App\Service\Admin\CategoryService;
use App\Service\Admin\CRUD\Creator\BlogCreator;
use App\Service\Admin\CRUD\Creator\CategoryCreator;
use App\Service\Admin\CRUD\Deleter\BlogDeleter;
use App\Service\Admin\BlogService;
use App\Service\Admin\CRUD\Fetcher\BlogFetcher;
use App\Service\Admin\CRUD\Fetcher\CategoryFetcher;
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
    public function addBlogAction(): RedirectResponse
    {
//        var_dump($request);exit();
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST) {
            /** @var CategoryFetcher $categoryFetcher */
            $categoryFetcher = $this->get(CategoryFetcher::class);
            $categories = $categoryFetcher->fetch();
            echo $this->get('twig')->render('addblog.html.twig', ['categories' => $categories]);
            exit();
        }

        /** @var BlogCreator $blogCreator */
        $blogCreator = $this->get(BlogCreator::class);
//        var_dump($this->getRequest()->request->get('categories'));exit();
        $blogCreator->create($this->getRequest());
        return new RedirectResponse("/admin/dashboard");

    }

    /**
     * @return RedirectResponse|null
     */
    public function addCategoryAction(): ?RedirectResponse
    {
        /** @var CategoryCreator $categoryService */
        $categoryService = $this->get(CategoryCreator::class);
        $categoryService->create($this->getRequest());
        return new RedirectResponse("/admin/dashboard");
    }


    public function getBlogAction()
    {
        /** @var BlogFetcher $blogFetcher */
        $blogFetcher = $this->get(BlogFetcher::class);
        $blogFetcher->fetch();
    }

    public function deleteBlogAction($id)
    {
        /** @var BlogDeleter $blogDeleter */
        $blogDeleter = $this->get(BlogDeleter::class);
        $blogDeleter->delete($id);

    }

    public function blogDetailAction($id)
    {
        /** @var BlogFetcher $blogFetcherById */
        $blogFetcherById = $this->get(BlogFetcher::class);
        $blog = $blogFetcherById->fetchById($id);
//        var_dump($blog);exit();
        return $this->get('twig')->render('detail.html.twig', ['blog' => $blog]);
    }
}