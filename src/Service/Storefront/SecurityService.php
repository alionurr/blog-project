<?php

namespace App\Service\Storefront;

use App\Entity\User;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class SecurityService extends AbstractService
{
    /**
     * @param $validateName
     * @param $validateEmail
     * @param $validatePassword
     * @param $validateConfirmPassword
     */
    public function register($validateName, $validateEmail, $validatePassword, $validateConfirmPassword)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();

        $user = new User();
        $user->setName($validateName);
        $user->setEmail($validateEmail);
        if ($validatePassword !== $validateConfirmPassword){
            echo "parolalar uyuşmuyor";
        }
        $user->setPassword(sha1($validatePassword));

        try {
            $entityManager->persist($user);
            $entityManager->flush($user);
        } catch (ORMException $e) {
            echo $e->getMessage();exit();
        }
    }

    public function login($validateEmail, $validatePassword)
    {
        /** @var EntityManager $entityManager */
        $userRepository = $entityManager = $this->getEntityManager();
        $foundUser = $userRepository->getRepository(User::class)->findOneBy(['email' => $validateEmail]);

        if (!$foundUser){
            echo "yanlış email";
        }
        $password = sha1($validatePassword);

        if ($password !== $foundUser->getPassword()) {
            echo "Yanlıs parola";
            exit();
        }
        $_SESSION['userName'] = $foundUser->getName();
    }
}
