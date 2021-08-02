<?php

namespace App\Service\Admin;

use App\Entity\AdminUser;
use App\Service\AbstractService;
use Doctrine\ORM\ORMException;
use Exception;


class SecurityService extends AbstractService
{
    /**
     * @param $validateName
     * @param $validateEmail
     * @param $validateConfirm
     * @param $validateConfirmPassword
     * @throws Exception
     */
    public function register($validateName, $validateEmail, $validateConfirm, $validateConfirmPassword)
    {
        $entityManager = $this->getEntityManager();
//        var_dump($request->request->all());exit();
        $adminUser = new AdminUser();
        $adminUser->setName($validateName);
        $adminUser->setEmail($validateEmail);
//        $password = $validateConfirm;
//        $confirmPassword = $validateConfirmPassword;
        if ($validateConfirm !== $validateConfirmPassword) {
            throw new Exception("Parolalar uyuşmuyor");
        }
        $adminUser->setPassword(sha1($validateConfirm));
        try {
            $entityManager->persist($adminUser);
            $entityManager->flush($adminUser);
        } catch (ORMException $e) {
            echo $e->getMessage();exit();
        }
    }

    /**
     * @param $validateEmail
     * @param $validatePassword
     */
    public function login($validateEmail, $validatePassword)
    {
//        var_dump($validateEmail);
//        var_dump($validatePassword);exit();
        $adminUserRepository = $this->getEntityManager()->getRepository(AdminUser::class);
        /** @var AdminUser $user */
        $user = $adminUserRepository->findOneBy(["email" => $validateEmail]);

        if (!$user) {
            echo "Yanlıs email";
            exit();
        }
        $password = sha1($validatePassword);

        if ($password !== $user->getPassword()) {
            echo "Yanlıs parola";
            exit();
        }
        $_SESSION['adminName'] = $user->getName();
    }
}