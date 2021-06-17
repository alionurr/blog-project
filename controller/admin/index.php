<?php

require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../../Slugger.php';

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
        $user = $conn->prepare("SELECT * FROM admin_user WHERE email = :email");
        $user->execute(array(
            'email' => $email,
        ));
        if ($user_data = $user->fetch(PDO::FETCH_ASSOC)) {
//            print_r($user_data);
            if ($password == $user_data['password']) {

                $_SESSION["name"] = $user_data['name'];
                Header("Location:../../views/admin/index.php");
            } else {
                Header("Location:../../views/admin/login.php");
            }
        } else {
            Header("Location:../../views/admin/login.php");
        }
    }
}



/*
 ********** LOG OUT **********
 */

if(isset($_POST['logout']))
{
    UNSET($_SESSION['name']);
    Header('Location: ../../views/admin/index.php');
}




/*
 ********** ADD POST **********
 */

if (isset($_POST['addPost']))
{
//    var_dump(__DIR__);

    $data = [
        'title' => htmlspecialchars($_POST['title']),
        'excerpt' => htmlspecialchars($_POST['excerpt']),
        'content' => htmlspecialchars($_POST['content']),
        'author' => $_SESSION['name'],
        'image' => $_FILES['image']['name'],
        'status' => 'pending',
    ];
    $targetDirection = ROOT."/resources/img/uploaded/".$_FILES['image']['name'];

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetDirection))
    {
        Header("Location: ../../views/admin/add_post.php?status=error");
    }
    else
    {
        $sql = "INSERT INTO blog (title, content, author, excerpt, image, status) VALUES (:title, :content, :author, :excerpt, :image, :status)";
        $post = $conn->prepare($sql);
        $post->execute($data);
        $blog_id = $conn->lastInsertId();

        $categories = $_POST['category'];
        $category = $conn->prepare("INSERT INTO blog_category (blog_id, category_id) VALUES (:blog_id, :category_id)");
        foreach ($categories as $c)
        {

            $category->execute([
                'blog_id' => $blog_id,
                'category_id' => $c,
            ]);
        }

        $tags = $_POST['tag'];
        $tag = $conn->prepare("INSERT INTO blog_tag SET blog_id=:blog_id, tag_id=:tag_id");
    //    print_r($tags);
    //    exit();
        foreach ($tags as $t) {
    //        print_r($t);
    //        exit();
            $tag->execute([
                'blog_id' => $blog_id,
                'tag_id' => $t
            ]);
        }
        Header("Location: ../../views/admin/index.php");
    }
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


        $tagQuery = $conn->prepare("SELECT tag_id FROM blog_tag AS bt INNER JOIN blog AS b ON b.id=bt.blog_id WHERE b.id=:id");
        $tagQuery->execute(['id' => $id]);
        $tags = $tagQuery->fetchAll(PDO::FETCH_ASSOC);

//        print_r($tags);exit();

        $t = array_map(function ($tag){
            return $tag['tag_id'];
        }, $tags);

        $post_tags = $_POST['tag'];

        $deleteTagDiff = array_diff($t, $post_tags);

        $deleteTagQuery = $conn->prepare("DELETE FROM blog_tag WHERE blog_id=:blog_id AND tag_id=:tag_id");
        foreach ($deleteTagDiff as $item) {
            $deleteTagQuery->execute([
                'blog_id' => $id,
                'tag_id' => $item
            ]);
        }

        $addTagDiff = array_diff($post_tags, $t);

        $addTagQuery = $conn->prepare("INSERT INTO blog_tag SET blog_id=:blog_id, tag_id=:tag_id");
        foreach ($addTagDiff as $item) {
            $addTagQuery->execute([
                'blog_id' => $id,
                'tag_id' => $item
            ]);
        }



        Header("Location: ../../views/admin/index.php");
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

    Header("Location: ../../views/admin/index.php");
}



/*
 ********** ADD A NEW CATEGORY **********
 */

if (isset($_POST['addCategory']))
{
//    echo "selamın aleykum dayıoglu";
    $c_name = htmlspecialchars($_POST['category_name']);
//    echo $c_name;
    ;


    $query = $conn->prepare("INSERT INTO category(name, slug) VALUES(:c_name, :c_slug)");
    $query->execute(['c_name' => $c_name, 'c_slug' => Slugger::createSlug($c_name)]);

    Header('Location:../../views/admin/index.php');
}



/*
 ********** ADD A NEW TAG **********
 */

if (isset($_POST['addTag']))
{
    $tag_name = htmlspecialchars($_POST['tag_name']);

//    print_r($tag_name);
//    exit();
    $tag = $conn->prepare("INSERT INTO tag(name) VALUES (:tag_name)");
    $tag->execute(['tag_name' => $tag_name]);

    Header('Location:../../views/admin/index.php');

}











































