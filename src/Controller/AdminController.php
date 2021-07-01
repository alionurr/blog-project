<?php


namespace App\Controller;


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
        $entityManager = $this->getEntityManager();
        /** @var SecurityService $securityService */
        $securityService = $this->get(SecurityService::class);
        $securityService->register($this->getRequest(), $entityManager);
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
        $entityManager = $this->getEntityManager();
        /** @var SecurityService $securityService */
        $securityService = $this->get(SecurityService::class);
        $securityService->login($this->getRequest(), $entityManager);
        if (isset($_SESSION['adminName'])) {
            return new RedirectResponse("/admin/dashboard");
        }
        return new RedirectResponse("/admin/login");
    }


}