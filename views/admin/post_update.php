<?php require_once("header.php"); ?>

<body>
<?php require_once("sidebar.php");?>

<div class="container" style="margin-top:50px;">

    <?php
        $id = $_GET['id'];

        $post = $conn->prepare("SELECT * FROM blog WHERE id='$id'");
        $post->execute();

        if ($p = $post->fetch(PDO::FETCH_ASSOC))
        {
//            print_r($p);
            $id = $p['id'];
            $title = $p['title'];
            $excerpt = $p['excerpt'];
            $content = $p['content'];
//            $updated_at = $p['updated_at'];
        }

    ?>

    <form action="../../controller/admin/index.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-row">
            <div class="form-group col-md">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="excerpt">Excerpt</label>
            <textarea type="text" class="form-control" style="height: 100px" name="excerpt" id="excerpt" placeholder="You can write summary your article."><?php echo $excerpt; ?></textarea>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea type="text" class="form-control" style="height: 200px" name="content" id="content" placeholder="You can write your article."><?php echo $content; ?></textarea>
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

        <div class="col-sm" style="margin-top: 10px;">
            <?php if(isset($_GET['blanks'])): ?>
                <div class="alert alert-warning">
                    <p><?php echo "Please fill the blanks!"; ?></p>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" name="updatePost" class="btn btn-primary btn-block mt-5">Update Post</button>
    </form>
</div>

</body>

<?php require_once("footer.php"); ?>
