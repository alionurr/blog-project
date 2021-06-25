<?php
    require_once ("header.php");
    use Blog\Category;
    use Blog\Blog;
?>

<body>
<?php require_once ("navbar.php"); ?>

<div style=" height: auto; width: 300px;position: fixed; right: 30px">
    <div class="card">
        <div class="card-header text-center">
            Categories
        </div>
        <div class="card-body">
            <ul class="list-group">

                <?php

                $categories = $entityManager->getRepository(Category::class)->findByMostCount();
//                var_dump($categories);exit();
//                $categoryArray = [];
//                foreach ($categories as $category) {
//                    $categoryArray[] = $category->getName();
//                }
//                echo implode(",", $categoryArray);

                /** @var Category $category */
                foreach ($categories as $category):
                    if($category->getBlogs()->count() > 0):
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="/views/category.php?category=<?php echo $category->getSlug(); ?>"><?php echo $category->getName(); ?></a>
                    <span class="badge badge-primary badge-pill"><?php echo $category->getBlogs()->count(); ?></span>
                </li>

                <?php endif;endforeach; ?>
            </ul>
        </div>
    </div>
</div>



    <content>
        <div class="container">
            <div class="row">

                <?php
                $numrecords = $entityManager->getRepository(Blog::class)->getTotalCountByParams();

                $numlinks = ceil($numrecords/$numperpage);
//                echo "number of page is ".$numlinks;
                $page = $_GET['start'] ?? 0;
                $start = $page * $numperpage;

                $blogs = $entityManager->getRepository(\Blog\Blog::class)->findByPaginationParam($start, $numperpage);
//                print_r($blogs);exit();

                /** @var Blog $blog */
                foreach ($blogs as $blog):
                ?>

                <div class="col-sm-4 mb-5">
                    <div class="card">
                        <h5 class="card-header"><?php echo $blog->getTitle(); ?></h5>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $blog->getTitle(); ?></h5>
                            <p class="card-text"><?php echo $blog->getExcerpt(); ?></p>
                            <a href="/views/post_detail.php?id=<?php echo $blog->getId(); ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php
//            $numperpage * $start;
            for ($i=0; $i<$numlinks; $i++){
                $y = $i +1;
                echo "<a href='index.php?start=$i'>$y</a> ";
            }


            ?>
        </div>
    </content>
</body>

<?php require_once ("footer.php"); ?>
