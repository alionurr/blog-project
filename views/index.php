<?php require_once ("header.php"); ?>

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

//                    $getCategories = $conn->prepare("SELECT * FROM category");
//                    $getCategories->execute();
//                    $categories = $getCategories->fetchAll(PDO::FETCH_ASSOC);
////                    print_r($categories);exit();

                    $countArticle = $conn->prepare("SELECT c.name, c.slug, COUNT(b.id) AS count
                                        FROM `blog` AS b 
	                                    INNER JOIN blog_category AS bc ON bc.blog_id = b.id
	                                    INNER JOIN category AS c ON c.id = bc.category_id
	                                    GROUP BY c.id");
                    $countArticle->execute();
                    $categories = $countArticle->fetchAll(PDO::FETCH_ASSOC);
//                    var_dump($categories);exit();
                foreach ($categories as $category):
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="/views/category.php?category=<?php echo $category['slug']; ?>"><?php echo $category['name']; ?></a>
                    <span class="badge badge-primary badge-pill"><?php echo $category['count']; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>



    <content>
        <div class="container">
            <div class="row">

                <?php

                $sql = $conn->prepare("SELECT COUNT(id) FROM blog");
                $sql->execute();
                $row = $sql->fetch();
//                echo "Total records ".$row[0];
                $numrecords = $row[0];
                $numlinks = ceil($numrecords/$numperpage);
//                echo "number of page is ".$numlinks;
                $page = $_GET['start'] ?? 0;
                $start = $page * $numperpage;


                $blog = $conn->prepare("SELECT * FROM blog limit $start, $numperpage");
                $blog->execute();
                $blogs = $blog->fetchAll(PDO::FETCH_ASSOC);
//                print_r($blogs);exit();

                foreach ($blogs as $b):
                ?>

                <div class="col-sm-4 mb-5">
                    <div class="card">
                        <h5 class="card-header"><?php echo $b['title']; ?></h5>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $b['title']; ?></h5>
                            <p class="card-text"><?php echo $b['excerpt']; ?></p>
                            <a href="/views/post_detail.php?id=<?php echo $b['id']; ?>" class="btn btn-primary">Read More</a>
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
