<?php
require_once("header.php");
//print_r($_SESSION);
?>

<body>
    <?php require_once("sidebar.php");?>

    <div class="container" style="  margin-top:50px;">

        <?php
        $id = $_GET['id'];

        $post = $conn->prepare("SELECT b.*, GROUP_CONCAT(DISTINCT (c.name))  AS category, GROUP_CONCAT(DISTINCT (t.name)) AS tag
                                        FROM blog_category AS bc 
                                        INNER JOIN category AS c ON c.id = bc.category_id 
                                        INNER JOIN blog AS b ON b.id = bc.blog_id 
                                        LEFT JOIN blog_tag AS bt ON bt.blog_id = b.id
                                        LEFT JOIN tag AS t ON t.id = bt.tag_id 
                                        WHERE b.id=:id GROUP BY bc.blog_id");
        $post->execute(['id' => $id]);
        if($p = $post->fetch(PDO::FETCH_ASSOC))
        {

                $id = $p['id'];
                $title = $p['title'];
                $content = $p['content'];
                $author = $p['author'];
                $excerpt = $p['excerpt'];
                $image = $p['image'];
                $status = $p['status'];
                $created_at = $p['created_at'];
                $category = $p['category'];
                $tag = $p['tag'];
//            print_r($p);
//            exit();
                ?>
            <div class="card">
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <img src="<?php echo "/resources/img/uploaded/".$image; ?>" alt="image does not exists" style="height: 250px; width: 250px;">
                    </div>
                    <div class="col-sm-6">
                        <div class="card-header">
                            <div class="float-right">
                                <div class="d-inline-block">
                                    Author: <?php echo $author; ?>
                                </div>
                                <div class="d-inline-block ml-3 text-secondary">
                                    Created_at: <?php echo $created_at ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $title; ?></h5>
                            <p class="card-text"><?php echo $content; ?></p>
                            <p class="card-text"><?php echo $category; ?></p>
                            <p class="card-text"><?php echo $tag; ?></p>
                            <div class="row">
                                <a href="post_update.php?id=<?php echo $id; ?>" class="btn btn-success mr-2">Update</a>
                                <form action="../../controller/admin/index.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input name="deleteButton" type="submit" class="btn btn-danger" value="Delete">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



                <?php
        }
        ?>
    </div>
</body>

<?php
require_once("footer.php");
?>