<?php

require_once __DIR__.'/../config.php';

use Blog\User;

/*
 ********** Register **********
 */
if (isset($_POST['register']))
{
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//    print_r($hashed_password);

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']))
    {
        Header('Location:../views/register.php?blanks=empty');
    }
    else
    {

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush($user);

        Header('Location:../views/login.php');
    }
}


/*
 ********** Login **********
 */

if (isset($_POST['login']))
{
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($_POST['email']) || empty($_POST['password']))
    {
        Header('Location:../views/login.php?blanks=empty');
    }
    else
    {
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(["email" => $email]);
//        var_dump($password);
//        var_dump($user->getPassword());
//        var_dump(password_verify($password, $user->getPassword()));exit;
        if ($user && password_verify($password, $user->getPassword()))
        {
            $_SESSION['user_name'] = $user->getName();
            Header('Location:../views/index.php');
        }
        else
        {
            Header('Location:../views/login.php');
        }
    }
}


/*
 ********** Log out **********
 */

if (isset($_POST['logout']))
{
    UNSET($_SESSION['user_name']);
    Header('Location:../views/index.php');
}


?>