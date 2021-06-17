<?php

require_once __DIR__.'/../config.php';


/*
 ********** Register **********
 */
if (isset($_POST['register']))
{
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
//    print_r($hashed_password);

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']))
    {
        Header('Location:../views/register.php?blanks=empty');
    }
    else
    {
        $user = $conn->prepare("INSERT INTO user SET name=:name, email=:email, password=:password");
        $user->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password,
        ]);
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

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($_POST['email']) || empty($_POST['password']))
    {
        Header('Location:../views/login.php?blanks=empty');
    }
    else
    {
        $user = $conn->prepare("SELECT * FROM user WHERE email=:email");
        $user->execute(['email' => $email]);

        if ($user_data = $user->fetch(PDO::FETCH_ASSOC))
        {
            if (password_verify($password, $hashed_password))
            {
                $_SESSION['user_name'] = $user_data['name'];
                Header('Location:../views/index.php');
            }
            else
            {
                Header('Location:../views/login.php');
            }
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