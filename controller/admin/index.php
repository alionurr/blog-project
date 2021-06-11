<?php

require_once __DIR__.'/../../config.php';

/*
 ********** ADMIN LOGIN **********
 */
if (isset($_POST['adminLogin']))
{
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($_POST['email']) || empty($_POST['password'])) {
        header('location:../../views/admin/login.php?status=wrong');
    } else {
        $user = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $user->execute(array(
            'email' => $email,
        ));
        if ($user_data = $user->fetch(PDO::FETCH_ASSOC)) {
//            print_r($user_data);
            if ($password == $user_data['password']) {

                $_SESSION["name"] = $user_data['name'];
                Header("Location:../../index.php");
            } else {
                Header("Location:../../views/admin/login.php");
            }
        } else {
            Header("Location:../../views/admin/login.php");
        }
    }
}


/*
 ********** ADD POST **********
 */

if (isset($_POST['addPost']))
{

//    var_dump($_POST['category']);
//    exit();
    $data = [
        'title' => htmlspecialchars($_POST['title']),
        'excerpt' => htmlspecialchars($_POST['excerpt']),
        'content' => htmlspecialchars($_POST['content']),
        'author' => $_SESSION['name'],
        'status' => 'pending',
    ];



    $sql = "INSERT INTO blog (title, content, author, excerpt, status) VALUES (:title, :content, :author, :excerpt, :status)";
    $post = $conn->prepare($sql);
    $post->execute($data);
    $blog_id = $conn->lastInsertId();

//    $category = $conn->prepare("INSERT INTO blog_category (blog_id, category_id) VALUES ($id, :category_id)");

    $categories = $_POST['category'];
    $category = $conn->prepare("INSERT INTO blog_category (blog_id, category_id) VALUES (:blog_id, :category_id)");
    foreach ($categories as $c)
    {

        $category->execute([
            'blog_id' => $blog_id,
            'category_id' => $c,
        ]);
    }

//    $data2 = [
//        'cat_name' => htmlspecialchars($_POST['category'])
//    ];
//
//    $sql2 = "INSERT INTO category (name) VALUE (:cat_name)";
//    $post2 = $conn->prepare($sql2);
//    $post2->execute($data2);

    Header("Location: ../../index.php");
}


/*
 ********** UPDATE POST **********
 */

if (isset($_POST['updatePost']))
{
    if (empty($_POST['title']) || empty($_POST['excerpt']) || empty($_POST['content']))
    {
        header('location:../../views/admin/post_update.php?blanks=empty');
    }
    else
    {
        $id = $_POST['id'];
        $data = [
            'id' => htmlspecialchars($id),
            'title' => htmlspecialchars($_POST['title']),
            'excerpt' => htmlspecialchars($_POST['excerpt']),
            'content' => htmlspecialchars($_POST['content']),
        ];

        $sql = "UPDATE blog SET title=:title, excerpt=:excerpt, content=:content WHERE id=:id";
        $post = $conn->prepare($sql);
        $post->execute($data);

        $query = $conn->prepare("SELECT category_id FROM blog_category AS bc INNER JOIN blog AS b ON b.id=bc.blog_id WHERE b.id=:id");
        $query->execute(array('id' => $id));
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);

        // make one-dimensional $categories
        $c =  array_map(function ($category){
            return $category['category_id'];
        }, $categories);
//        print_r( $c);
//        $new_array = array();
//        foreach($categories as $array)
//        {
//            foreach($array as $val)
//            {
//                array_push($new_array, $val);
//            }
//        }
//        print_r($new_array);


//        print_r($categories);
//        exit();


        $post_categories = $_POST['category'];
//        print_r($post_categories) ;
//        exit();

        $result = array_diff($c,$post_categories);
//        print_r($result);
//        exit();


        $query = $conn->prepare("DELETE FROM blog_category WHERE blog_id=:blog_id AND category_id=:category_id");

        foreach ($result as $item) {
            $query->execute([
                'blog_id' => $id,
                'category_id' => $item,
            ]);
        }


        $result2 = array_diff($post_categories,$c);
//        print_r($result2);
//        exit();
        $query2 = $conn->prepare("INSERT INTO blog_category SET blog_id=:blog_id, category_id=:category_id");
        foreach ($result2 as $item) {
            $query2->execute([
                'blog_id' => $id,
                'category_id' => $item,
            ]);
        }

        Header("Location: ../../index.php");
    }
}

/*
 ********** DELETE POST **********
 */

if (isset($_POST['deleteButton']))
{
    $id = $_POST['id'];
//    echo $id;
    $sql = "DELETE FROM blog WHERE id = '$id' ";
    $post = $conn->prepare($sql);
    $post->execute([$id]);

    Header("Location: ../../index.php");
}



/*
 ********** ADD A NEW CATEGORY **********
 */

if (isset($_POST['addCategory']))
{
//    echo "selamın aleykum dayıoglu";
    $c_name = htmlspecialchars($_POST['category_name']);
//    echo $c_name;

    $query = $conn->prepare("INSERT INTO category SET name=:c_name");
    $query->execute(['c_name' => $c_name]);

    Header('Location:../../index.php');
}



/*
 ********** LOG OUT **********
 */

if(isset($_POST['logout']))
{
    session_destroy();
    Header('Location: ../../index.php');
}












































