<?php require_once ("header.php"); ?>

<body>
<?php require_once ("navbar.php"); ?>

    <content>
        <div class="container">
            <?php
            $categorySlug = $_GET['category'];
//            print_r($category);exit();
            /** @var \Blog\Category $categoryEntity */
            $categoryEntity = $entityManager->getRepository(\Blog\Category::class)->findOneBy(['slug' => $categorySlug]);

            /** @var \Blog\Blog $blog */
            foreach ($categoryEntity->getBlogs() as $blog){
                var_export($blog->getTitle());
            }

//            $post = $conn->prepare("SELECT * FROM blog WHERE id=:id");
//            $post->execute(['id' => $id]);
//            if ($postDetail = $post->fetch(PDO::FETCH_ASSOC))
//            {
//                $title = $postDetail['title'];
//                $excerpt = $postDetail['excerpt'];
//                $content = $postDetail['content'];
//                $author = $postDetail['author'];
//            }
//            ?>
<!--            <div class="container">-->
<!--                <div class="card text-center">-->
<!--                    <div class="card-header">-->
<!--                        Featured-->
<!--                    </div>-->
<!--                    <div class="card-body">-->
<!--                        <h5 class="card-title">--><?php //echo $title; ?><!--</h5>-->
<!--                        <p class="card-text">--><?php //echo $content; ?><!--</p>-->
<!--                               <a href="#" class="btn btn-primary">Go somewhere</a>-->
<!--                    </div>-->
<!--                    <div class="card-footer text-muted">-->
<!--                        Author: --><?php //echo $author; ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </content>
</body>

<?php require_once ("footer.php"); ?>
