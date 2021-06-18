<?php require_once("header.php"); ?>

<body>
<?php require_once("sidebar.php");?>

<div class="container mb-5" style="margin-top:50px;">

    <?php
        $id = $_GET['id'];

        $post = $conn->prepare("SELECT * FROM blog WHERE id=:id");
        $post->execute(['id' => $id]);

        if ($p = $post->fetch(PDO::FETCH_ASSOC))
        {
//            print_r($p);
            $id = $p['id'];
            $title = $p['title'];
            $excerpt = $p['excerpt'];
            $content = $p['content'];
            $image = $p['image'];
//            $updated_at = $p['updated_at'];
        }

    ?>

    <form action="../../controller/admin/index.php" method="post" enctype="multipart/form-data">
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

        <div class="mb-3">
            <label for="formFile" class="form-label">Default file input example</label>
            <input class="form-control" type="file" name="image" id="formFile">
            <img src="<?= '/resources/img/uploaded/'.$image ?>"  alt="image does not exists" style="height: 200px;width: 300px;">
        </div>


        <div>
            <label for="category">Select Category</label>
            <select class="js-example-basic-multiple" style="width: 100%" name="category[]" multiple="multiple">
                <?php

                $category = $conn->prepare("SELECT * FROM category");
                $category->execute();

                $a = "SELECT DISTINCT(c.id) FROM category AS c INNER JOIN blog_category AS bc ON bc.category_id=c.id WHERE bc.blog_id=:id";
                $selectedCategoryQuery = $conn->prepare($a);
                $selectedCategoryQuery->execute(['id' => $id]);
                $selectedCategories = [];
                foreach ($selectedCategoryQuery->fetchAll() as $selectedCategory){
                    $selectedCategories[] = $selectedCategory['id'];
                }

                if ($results = $category->fetchAll(PDO::FETCH_ASSOC))
                {
    //                    print_r($result);
                    foreach ($results as $result)
                    {
                        $cat_id = $result['id'];
                        $name = $result['name'];

                        ?>

                        <option value="<?php echo $cat_id; ?>" <?php if(in_array($cat_id, $selectedCategories)) echo "selected";?>><?php echo $name; ?></option>

                        <?php
                    }
                }
                ?>
            </select>
        </div>


        <div class="mt-3">
            <label for="tag">Select Tag</label>
            <select class="js-example-basic-multiple" style="width: 100%" name="tag[]" multiple="multiple">

                <?php
                    $tag = $conn->prepare("SELECT * FROM tag");
                    $tag->execute();

                    $selectedTag = $conn->prepare("SELECT t.id FROM tag AS t INNER JOIN blog_tag AS bt ON bt.tag_id=t.id WHERE bt.blog_id=:id");
                    $selectedTag->execute(['id' => $id]);

                    $selectedTags = [];
                    foreach ($selectedTag->fetchAll(PDO::FETCH_ASSOC) as $selected_tag) {
                        $selectedTags[] = $selected_tag['id'];
                    }

                    if ($results = $tag->fetchAll(PDO::FETCH_ASSOC))
                    {
                        foreach ($results as $result) {
                            $tag_id = $result['id'];
                            $tag_name = $result['name'];

                ?>
                            <option value="<?php echo $tag_id ?>" <?php if(in_array($tag_id, $selectedTags)) echo "selected";?>><?php echo $tag_name?></option>
                <?php
                        }
                    }
                ?>

            </select>
        </div>


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
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
</body>

<?php require_once("footer.php"); ?>
