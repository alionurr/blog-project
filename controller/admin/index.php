<?php

require_once __DIR__.'/../../config.php';

/*
 *  ADMIN LOGIN
 */
if (isset($_POST['adminLogin'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($_POST['email']) || empty($_POST['password'])) {
        header('location:../../index.php?status=wrong');
    } else {
        $user = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $user->execute(array(
            'email' => $email,
        ));
        if ($user_data = $user->fetch(PDO::FETCH_ASSOC)) {
//            print_r($user_data);
            if ($password == $user_data['password']) {

                $_SESSION["name"] = $user_data['name'];
                Header("Location:../../views/home.php");
            } else {
                Header("Location:../../index.php");
            }
        } else {
            Header("Location:../../index.php");
        }
    }
}


/*
 *
 */