<?php

namespace App\Controller\Storefront;

use App\Controller\AbstractController;
use App\Service\Storefront\SecurityService;
use App\Validation\LoginValidator;
use App\Validation\RegisterValidator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    public function signUpAction(): RedirectResponse
    {
        if($this->getRequest()->getMethod() !== Request::METHOD_POST)
        {
            $errors = [];
            if (isset($_SESSION['errors'])){
                $errors = $_SESSION['errors'];
                unset($_SESSION['errors']);
            }
            echo $this->get('twig')->render('storefront/register.html.twig', ['errors' => $errors]);
        }

        $validator = new RegisterValidator($this->getRequest());
        $validator->validateForRegister();
        if (!empty($validator->errors)){
            $_SESSION['errors'] = $validator->errors;
            return new RedirectResponse('/sign-up');
        }

        /** @var SecurityService $securityService */
        $securityService = $this->get(SecurityService::class);
        $securityService->register($validator->name, $validator->email, $validator->password, $validator->confirmPassword);
        return new RedirectResponse('/login');
    }

    public function loginAction(): RedirectResponse
    {
        if ($this->getRequest()->getMethod() !== Request::METHOD_POST){
            $errors = [];
            if (isset($_SESSION['errors'])){
                $errors = $_SESSION['errors'];
                unset($_SESSION['errors']);
            }
            echo $this->get('twig')->render('storefront/login.html.twig', ['errors' => $errors]);
        }
        $validator = new LoginValidator($this->getRequest());
        $validator->validateForLogin();
        if (!empty($validator->errors)){
            $_SESSION['errors'] = $validator->errors;
            return new RedirectResponse('/login');
        }
        /** @var SecurityService $securityService */
        $securityService = $this->get(SecurityService::class);
        $securityService->login($validator->email, $validator->password);
        return new RedirectResponse('/');
    }

    /**
     * @return RedirectResponse
     */
    public function logoutAction(): RedirectResponse
    {
        unset($_SESSION['userName']);
        return new RedirectResponse("/");
    }
}