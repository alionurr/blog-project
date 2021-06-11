<?php
require_once("header.php");
//print_r($_SESSION);
?>

<body>
    <?php require_once("sidebar.php");?>

    <div class="container" style="margin-top:50px;">

        <?php
        $id = $_GET['id'];

        $post = $conn->prepare("SELECT * FROM blog WHERE id = '$id'");
        $post->execute();
        if($p = $post->fetch(PDO::FETCH_ASSOC))
        {
//            print_r($post_result);

                $id = $p['id'];
                $title = $p['title'];
                $content = $p['content'];
                $author = $p['author'];
                $excerpt = $p['excerpt'];
                $status = $p['status'];
                $created_at = $p['created_at'];

                ?>
                <div class="card" style="margin-top: 50px">
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
                        <div class="row">
                            <a href="post_update.php?id=<?php echo $id; ?>" class="col-sm-2 text-success">Update</a>
                            <form action="../../controller/admin/index.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input name="deleteButton" type="submit" value="Delete" style="border: 0; background-color: #fff; color: red;">
                            </form>
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