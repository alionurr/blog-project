<?php
require_once(__DIR__ . "/header.php");
//print_r($_SESSION);
?>

    <body>
    <?php require_once(__DIR__ . "/sidebar.php");?>

    <div class="container" style="margin-top:50px;">
<!--            <h1>Welcome, Admin <span class="text-uppercase">--><?//= $_SESSION['name'] ?><!--</span></h1>-->
        <div class="row">
            <div class="col-sm-6">
                <?php if(isset($_SESSION['name'])): ?>
                    <form action="../../controller/admin/index.php" method="post">
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

                            <form action="../../controller/admin/index.php" method="post">
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
    </div>
    </body>

<?php
require_once(__DIR__ . "/footer.php");
?>