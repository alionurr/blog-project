<?php
require_once("header.php");

use Blog\Blog;
use Blog\Category;
use Blog\Tag;
//print_r($_SESSION);
?>

<body>
    <?php require_once("sidebar.php");?>

    <div class="container" style="  margin-top:50px;">

        <?php
        $id = $_GET['id'];

        /**
         * @var Blog $blogDetail
         */
        $blogDetail = $entityManager->getRepository(Blog::class)->find($id);

        $categoryNames = [];
        $tagNames = [];

        /** @var Category $category */
        /** @var Tag $tag */

        foreach ($blogDetail->getCategories() as $category){
            $categoryNames[] = $category->getName();
        }
        foreach ($blogDetail->getTags() as $tag) {
            $tagNames[] = $tag->getName();
        }
        ?>
            <div class="card">
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <img src="<?php echo "/resources/img/uploaded/".$blogDetail->getImage(); ?>" alt="image does not exists" style="height: 250px; width: 250px;">
                    </div>
                    <div class="col-sm-6">
                        <div class="card-header">
                            <div class="float-right">
                                <div class="d-inline-block">
                                    Author: <?php echo $blogDetail->getAuthor(); ?>
                                </div>
                                <div class="d-inline-block ml-3 text-secondary">
                                    Created_at: <?php ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $blogDetail->getTitle(); ?></h5>
                            <p class="card-text"><?php echo $blogDetail->getContent(); ?></p>
                            <p class="card-text"><?php echo implode(", ",$categoryNames); ?></p>
                            <p class="card-text"><?php echo implode(", ",$tagNames) ?></p>
                            <div class="row">
                                <a href="post_update.php?id=<?php echo $blogDetail->getId(); ?>" class="btn btn-success mr-2">Update</a>
                                <form action="../../controller/admin/index.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $blogDetail->getId(); ?>">
                                    <input name="deleteButton" type="submit" class="btn btn-danger" value="Delete">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</body>

<?php
require_once("footer.php");
?>