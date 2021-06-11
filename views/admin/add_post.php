<?php require_once("header.php"); ?>

<body>
    <?php require_once("sidebar.php");?>

    <div class="container" style="margin-top:50px;">

        <form action="../../controller/admin/index.php" method="post">
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title">
                </div>
            </div>
            <div class="form-group">
                <label for="excerpt">Excerpt</label>
                <textarea type="text" class="form-control" style="height: 100px" name="excerpt" id="excerpt" placeholder="You can write summary your article."></textarea>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea type="text" class="form-control" style="height: 200px" name="content" id="content" placeholder="You can write your article."></textarea>
            </div>



            <select class="js-example-basic-multiple" style="width: 100%" name="category[]" multiple="multiple">
            <?php

                $category = $conn->prepare("SELECT * FROM category");
                $category->execute();

                if ($results = $category->fetchAll(PDO::FETCH_ASSOC))
                {
//                    print_r($result);
                    foreach ($results as $result)
                    {
                        $id = $result['id'];
                        $name = $result['name'];

                ?>

                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>

                        <?php
                    }
                }
                ?>
            </select>


            <button type="submit" name="addPost" class="btn btn-primary btn-block mt-5">Add Post</button>
        </form>
    </div>

</body>

<?php require_once("footer.php"); ?>
