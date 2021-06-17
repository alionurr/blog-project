<?php require_once ("header.php"); ?>

<body>
<?php require_once ("navbar.php"); ?>

    <content>
        <div class="container">
            <?php
            $category = $_GET['category'];
//            print_r($category);exit();

            $categoryArticlesQuery = "SELECT b.* 
                                        FROM `blog` AS b 
	                                    INNER JOIN blog_category AS bc ON bc.blog_id = b.id
	                                    INNER JOIN category AS c ON c.id = bc.category_id 
                                        WHERE c.slug='".$category."'    
                                        GROUP BY b.id";
            $article = $conn->prepare($categoryArticlesQuery);
            $article->execute();
            foreach ($article->fetchAll() as $item){
                print_r($item);Exit;
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
