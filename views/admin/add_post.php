<?php
    require_once("header.php");

    use Blog\Blog;
    use Blog\Category;
    use Blog\Tag;

    ?>

<body>
    <?php require_once("sidebar.php");?>

    <div class="container" style="margin-top:50px; margin-bottom:50px;">

        <form action="../../controller/admin/index.php" method="post" enctype="multipart/form-data">
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

            <div class="col-sm" style="margin-top: 10px;">
                <?php if(isset($_GET['status'])): ?>
                    <div class="alert alert-warning">
                        <p><?php echo "Please add a photograph!"; ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Default file input example</label>
                <input class="form-control" type="file" name="image" id="formFile">
            </div>

            <div>
                <label for="category">Select Category</label>
                    <select id="category" class="js-example-basic-multiple" style="width: 100%" name="category[]" multiple="multiple">
                        <?php

                        /**
                         * @var Category $categories
                         */

                        $categories = $entityManager->getRepository(Category::class)->findAll();
                        foreach ($categories as $category) {
                            $categoryId = $category->getId();
                            $categoryName = $category->getName();

                            ?>

                            <option value="<?php echo $categoryId; ?>"><?php echo $categoryName; ?></option>

                        <?php

                            }
                            ?>
                    </select>
            </div>





            <div class="mt-3">
                <label for="tag">Select Tag</label>
                <select id="tag" class="js-example-basic-multiple" style="width: 100%" name="tag[]" multiple="multiple">

                    <?php

                    /**
                     * @var Tag $tags
                     */

                    $tags = $entityManager->getRepository(Tag::class)->findAll();

                    foreach ($tags as $tag) {
                        $tagId = $tag->getId();
                        $tagName = $tag->getName();

                    ?>

                    <option value="<?php echo $tagId; ?>"><?php echo $tagName; ?></option>

                    <?php
                        }
                    ?>
                </select>
            </div>

            <button type="submit" name="addPost" class="btn btn-primary btn-block mt-5">Add Post</button>
        </form>
    </div>

</body>

<?php require_once("footer.php"); ?>
