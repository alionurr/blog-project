<?php
namespace App\Service\Admin;

use App\Entity\AdminUser;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityService
{
    /**
     * @throws Exception
     */
    public function register(Request $request, $entityManager)
    {
//        var_dump($request->request->all());exit();
        $adminUser = new AdminUser();
        $adminUser->setName($request->request->get("name"));
        $adminUser->setEmail($request->request->get("email"));
        $password = $request->request->get("password");
        $confirmPassword = $request->request->get("confirmPassword");
        if ($password !== $confirmPassword) {
            throw new Exception("Şifreler uyuşmuyor");
        }
        $adminUser->setPassword(sha1($request->request->get("password")));
        $entityManager->persist($adminUser);
        $entityManager->flush($adminUser);
    }

    /**
     * @return RedirectResponse
     * @param Request $request
     * @param $entityManager
     */
    public function login(Request $request, $entityManager)
    {

        $adminUserRepository = $entityManager->getRepository(AdminUser::class);
        /** @var AdminUser $user */
        $user = $adminUserRepository->findOneBy(["email" => $request->request->get("email")]);
        if(!$user) {
            echo "hatalı";exit();
        }
        $password = sha1($request->request->get("password"));

        if($password !== $user->getPassword())
        {
            echo "Hatalı";exit();
        }
        $_SESSION['adminName'] = $user->getName();
    }
}