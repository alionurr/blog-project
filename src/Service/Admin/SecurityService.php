<?php

namespace App\Service\Admin;

use App\Entity\AdminUser;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class SecurityService extends AbstractService
{
    /**
     * @param Request $request
     * @throws Exception
     */
    public function register(Request $request)
    {
        $entityManager = $this->getEntityManager();
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
        try {
            $entityManager->persist($adminUser);
            $entityManager->flush($adminUser);
        } catch (ORMException $e) {
            echo $e->getMessage();exit();
        }
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        $adminUserRepository = $this->getEntityManager()->getRepository(AdminUser::class);
        /** @var AdminUser $user */
        $user = $adminUserRepository->findOneBy(["email" => $request->request->get("email")]);
        if (!$user) {
            echo "hatalı";
            exit();
        }
        $password = sha1($request->request->get("password"));

        if ($password !== $user->getPassword()) {
            echo "Hatalı";
            exit();
        }
        $_SESSION['adminName'] = $user->getName();
    }
}