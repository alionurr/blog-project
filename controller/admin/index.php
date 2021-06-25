<?php

require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../../Slugger.php';
require_once __DIR__.'/../../FileUpload.php';
//require_once __DIR__.'/../../src/Product.php';

use Blog\AdminUser;
use Blog\Blog;
use Blog\Category;
use Blog\BlogCategory;
use Blog\Tag;
use Blog\BlogTag;


/*
 ********** ADMIN LOGIN **********
 */
if (isset($_POST['adminLogin']))
{
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($_POST['email']) || empty($_POST['password'])) {
        header('location:../../views/admin/login.php?status=wrong');
    }
    else
    {
        $adminUserRepository = $entityManager->getRepository(AdminUser::class);
        $adminUser = $adminUserRepository->findOneBy(['email' => $email]);
//        var_dump($admin_user->getPassword());
//        var_dump($password);
//        exit();
        if ($adminUser && password_verify($password, $adminUser->getPassword()))
        {
            $_SESSION['name'] = $adminUser->getName();
            Header('Location:../../views/admin/index.php');
        }
        else
        {
            Header('Location:../views/admin/login.php');

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
        'status' => 'pending',
    ];

    $photoDirection = ROOT."/resources/img/uploaded/";
    $upload = FileUpload::upload($_FILES['image'], $photoDirection);
    if (!$upload)
    {
        Header("Location: ../../views/admin/add_post.php?status=error");
    }
    else
    {
        $data["image"] = $upload;

        $blog = new Blog();
        $blog->setTitle($data['title']);
        $blog->setExcerpt($data['excerpt']);
        $blog->setContent($data['content']);
        $blog->setAuthor($data['author']);
        $blog->setStatus($data['status']);
        $blog->setImage($data['image']);
        $blog->setCreatedAt(new \DateTime());
        $blog->setUpdatedAt(new \DateTime());


        $categories = $_POST['category'];
        $categoryEntities = $entityManager->getRepository(Category::class)->findById($categories);
        foreach ($categoryEntities as $categoryEntity){
            $blog->addCategory($categoryEntity);
        }

        $tags = $_POST['tag'];
        $tagEntities = $entityManager->getRepository(Tag::class)->findById($tags);
        foreach ($tagEntities as $tagEntity) {
            $blog->addTag($tagEntity);
        }

        $entityManager->persist($blog);
        $entityManager->flush($blog);

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


        /**
         * @var Blog $blog
         */
        $blog = $entityManager->getRepository(Blog::class)->find($id);
        $imageName = $blog->getImage();

//        $q = $conn->prepare("SELECT image FROM blog WHERE id=:id");
//        $q->execute(['id' => $id]);
//        $imageName = $q->fetch(PDO::FETCH_COLUMN);

        $photoDirection = ROOT."/resources/img/uploaded/";


        if(isset($_FILES['image'])){
            $imageUpload = FileUpload::upload($_FILES['image'], $photoDirection);
            if (!$imageUpload)
            {
                header('location:../../views/admin/post_update.php?id='.$id.'&status=error');exit();
            }
            FileUpload::remove($imageName, $photoDirection);
        }

        $data['image'] = $imageUpload ?? $imageName;
//        $sql = "UPDATE blog SET title=:title, excerpt=:excerpt, image=:image, content=:content WHERE id=:id";
//        $post = $conn->prepare($sql);
//        $post->execute($data);


        $blog->setTitle($data['title']);
        $blog->setExcerpt($data['excerpt']);
        $blog->setContent($data['content']);
        $blog->setImage($data['image']);

        $postCategories = $_POST['category'];

        /**
         * @var Category $categories
         */
        $categories = $entityManager->getRepository(Category::class)->findById($postCategories);


        foreach ($blog->getCategories() as $blogCategory){
            if(!in_array($blogCategory->getId(), $postCategories)){
                $blog->removeCategory($blogCategory);
            }
        }

        foreach ($categories as $category) {
            $blog->addCategory($category);
        }

        $postTags = $_POST['tag'];

        /**
         * @var Tag $tags
         */
        $tags = $entityManager->getRepository(Tag::class)->findById($postTags);

        foreach ($blog->getTags() as $blogTag) {
            if (!in_array($blogTag->getId(), $postTags)){
                $blog->removeTag($blogTag);
            }
        }

        foreach ($tags as $tag) {
            $blog->addTag($tag);
        }

        $entityManager->persist($blog);
        $entityManager->flush($blog);

        Header("Location: ../../views/admin/index.php");
    }
}

/*
 ********** DELETE POST **********
 */

if (isset($_POST['deleteButton']))
{
    $id = $_POST['id'];

    $deleteBlog = $entityManager->getRepository(Blog::class);
    $delete = $deleteBlog->find($id);
    $entityManager->remove($delete);
    $entityManager->flush();

    Header("Location: ../../views/admin/index.php");
}



/*
 ********** ADD A NEW CATEGORY **********
 */

if (isset($_POST['addCategory']))
{
    $categoryName = htmlspecialchars($_POST['category_name']);

    $category = new Category();
    $category->setName($categoryName);
    $category->setSlug(Slugger::createSlug($categoryName));
    $entityManager->persist($category);
    $entityManager->flush($category);

    Header('Location:../../views/admin/index.php');
}


/*
 ********** ADD A NEW TAG **********
 */

if (isset($_POST['addTag']))
{
    $tagName = htmlspecialchars($_POST['tag_name']);

    $tag = new Tag();
    $tag->setName($tagName);
    $entityManager->persist($tag);
    $entityManager->flush($tag);

    Header('Location:../../views/admin/index.php');

}











































