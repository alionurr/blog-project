<?php
require_once(__DIR__ . "/views/admin/header.php");
//print_r($_SESSION);
?>

    <body>
    <?php require_once(__DIR__ . "/views/admin/sidebar.php");?>

    <div class="container" style="margin-top:50px;">
<!--            <h1>Welcome, Admin <span class="text-uppercase">--><?//= $_SESSION['name'] ?><!--</span></h1>-->
        <div class="row">
            <div class="col-sm-6">
                <?php if(isset($_SESSION['name'])): ?>
                    <form action="/controller/admin/index.php" method="post">
                        <button type="submit" name="logout" class="btn btn-primary">Log out</button>
                    </form>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary ">Login</a>
                <?php endif ?>
            </div>
            <?php
            if (isset($_SESSION['name'])):
                ?>
            <div class="col-sm-2">
                <a href="/views/admin/add_post.php" type="button" class="btn btn-primary">
                    Add Post
                </a>
            </div>
            <div class="col-sm-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Add Category
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add a new Category</h5>
<!--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                                    <span aria-hidden="true">&times;</span>-->
<!--                                </button>-->
                            </div>
                            <form action="../../controller/admin/index.php" method="post">
                            <div class="modal-body">
                                <input type="text" name="category_name" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="addCategory" class="btn btn-primary">Save changes</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
                    Add Tag
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add a new Tag</h5>
<!--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                                    <span aria-hidden="true">&times;</span>-->
<!--                                </button>-->
                            </div>

                            <form action="/controller/admin/index.php" method="post">
                                <div class="modal-body">
                                    <input type="text" name="tag_name" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="addTag" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            endif;
            ?>

        </div>

        <div class="mt-5">
            <table id="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>title</th>
                        <th>author</th>
                        <th>excerpt</th>
                        <th>status</th>
                        <th>categories</th>
                        <th>buttons</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!--     --><?php
        //            $posts = $conn->prepare("SELECT * FROM blog");
        //            $posts->execute();
        //            if($posts_result = $posts->fetchAll(PDO::FETCH_ASSOC))
        //            {
        ////            print_r($posts_result);
        //                foreach ($posts_result as $post)
        //                {
        //                    $id = $post['id'];
        //                    $title = $post['title'];
        //                    $author = $post['author'];
        //                    $excerpt = $post['excerpt'];
        //                    $status = $post['status'];
        ////                    $created_at = $post['created_at'];
        //
        //            ?>

        <!--            <div class="card" style="margin-top: 50px; margin-bottom: 50px">-->
        <!--                <div class="card-header">-->
        <!--                    <div class="float-right">Author: --><?php //echo $author; ?><!--</div>-->
        <!--                </div>-->
        <!--                <div class="card-body">-->
        <!--                    <h5 class="card-title">--><?php //echo $title; ?><!--</h5>-->
        <!--                    <p class="card-text">--><?php //echo $excerpt; ?><!--</p>-->
        <!--                    <div class="row">-->
        <!--                        <a href="./post_detail.php?id=--><?php //echo $id ?><!--" class="col-sm-2 text-primary">View</a>-->
        <!--                        <a href="./post_update.php?id=--><?php //echo $id; ?><!--" class="col-sm-2 text-success">Update</a>-->
        <!--                        <form action="../controller/admin/index.php" method="post">-->
        <!--                            <input type="hidden" name="id" value="--><?php //echo $id; ?><!--">-->
        <!--                            <input name="deleteButton" type="submit" value="Delete" style="border: 0; background-color: #fff; color: red;">-->
        <!--                        </form>-->
        <!--                   <p class="col-sm-6 text-secondary">Created_at: --><?php ////echo $created_at ?><!--</p>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->

        <!--                --><?php
        //                }
        //            }
        //        ?>
    </div>
    </body>

<?php
require_once(__DIR__ . "/views/admin/footer.php");
?>