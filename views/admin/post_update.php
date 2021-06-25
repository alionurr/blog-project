<?php
    require_once("header.php");

    use Blog\Blog;
    use Blog\Category;
    use Blog\Tag;
?>

<body>
<?php require_once("sidebar.php");?>

<div class="container mb-5" style="margin-top:50px;">

    <?php
        $id = $_GET['id'];

    /**
     * @var Blog $blog
     */
        $blog = $entityManager->getRepository(Blog::class)->find($id);


    ?>

    <form action="../../controller/admin/index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $blog->getId(); ?>">
        <div class="form-row">
            <div class="form-group col-md">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $blog->getTitle(); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="excerpt">Excerpt</label>
            <textarea type="text" class="form-control" style="height: 100px" name="excerpt" id="excerpt" placeholder="You can write summary your article."><?php echo $blog->getExcerpt(); ?></textarea>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea type="text" class="form-control" style="height: 200px" name="content" id="content" placeholder="You can write your article."><?php echo $blog->getContent(); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="formFile" class="form-label">Default file input example</label>
            <input class="form-control" type="file" name="image" id="formFile">
            <img src="<?= '/resources/img/uploaded/'.$blog->getImage(); ?>"  alt="image does not exists" style="height: 200px;width: 300px;">
        </div>


        <div>
            <label for="category">Select Category</label>
            <select class="js-example-basic-multiple" style="width: 100%" name="category[]" multiple="multiple">

                <?php

                $blogCategories = $blog->getCategories();
                $selectedCategories = [];
                /**
                 * @var Category $blogCategory
                 */
                foreach ($blogCategories as $blogCategory) {
                    $selectedCategories[] = $blogCategory->getId();
                }

                $categories = $entityManager->getRepository(Category::class)->findAll();
                $allCategories = [];
                $categoriesId = [];
                /**
                 * @var Category $category
                 */
                foreach ($categories as $category) {
                    $categoriesId = $category->getId();
                    $allCategories = $category->getName();

                        ?>

                        <option value="<?php echo $categoriesId; ?>" <?php if (in_array($categoriesId, $selectedCategories)) echo "selected"; ?>><?php echo $allCategories; ?></option>

                        <?php
                    }
                ?>
            </select>
        </div>


        <div class="mt-3">
            <label for="tag">Select Tag</label>
            <select class="js-example-basic-multiple" style="width: 100%" name="tag[]" multiple="multiple">

                <?php
//                    $tag = $conn->prepare("SELECT * FROM tag");
//                    $tag->execute();
//
//                    $selectedTag = $conn->prepare("SELECT t.id FROM tag AS t INNER JOIN blog_tag AS bt ON bt.tag_id=t.id WHERE bt.blog_id=:id");
//                    $selectedTag->execute(['id' => $id]);
//
//                    $selectedTags = [];
//                    foreach ($selectedTag->fetchAll(PDO::FETCH_ASSOC) as $selected_tag) {
//                        $selectedTags[] = $selected_tag['id'];
//                    }
//
//                    if ($results = $tag->fetchAll(PDO::FETCH_ASSOC))
//                    {
//                        foreach ($results as $result) {
//                            $tag_id = $result['id'];
//                            $tag_name = $result['name'];



                $blogTags = $blog->getTags();
                $selectedTags = [];
                /**
                 * @var Tag $blogTag
                 */
                foreach ($blogTags as $blogTag) {
                    $selectedTags[] = $blogTag->getId();
                }


                $tags = $entityManager->getRepository(Tag::class)->findAll();
                $allTags = [];
                $tagId = [];
                /**
                 * @var Tag $tag
                 */
                foreach ($tags as $tag) {
                    $allTags = $tag->getName();
                    $tagId = $tag->getId();

                ?>
                            <option value="<?php echo $tagId; ?>" <?php if(in_array($tagId, $selectedTags)) echo "selected";?>><?php echo $allTags;?></option>
                <?php
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
