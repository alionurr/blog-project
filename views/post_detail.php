<?php
    require_once ("header.php");
    use Blog\Blog;
?>

<body>
<?php require_once ("navbar.php"); ?>

<?php
        $id = $_GET['id'];

        /** @var Blog $blog */
        $blog = $entityManager->getRepository(Blog::class)->find($id);
///** @var \Blog\Category $category */
//foreach ($blog->getCategories() as $category){
//    var_dump($category->getName());
//}
//
//foreach ($blog->getTags() as $tag){
//    var_dump($tag->getName());
//}
//exit;
    ?>
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                Featured
            </div>
            <div class="card-body">
                <img src="<?='/resources/img/uploaded/'.$blog->getImage(); ?>" alt="image does not exists">
                <h5 class="card-title"><?php echo $blog->getTitle(); ?></h5>
                <p class="card-text"><?php echo $blog->getContent(); ?></p>
        <!--        <a href="#" class="btn btn-primary">Go somewhere</a>-->
            </div>
            <div class="card-footer text-muted">
                Author: <?php echo $blog->getAuthor(); ?>
            </div>
        </div>
    </div>
</body>


<?php require_once ("footer.php"); ?>

