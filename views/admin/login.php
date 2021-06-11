<?php
require_once("header.php");

if(isset($_SESSION['name']))
{
    Header('Location:/index.php');
}

?>

<body>
<div class="container">
    <div class="row" style="margin-top: 200px;">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <form action="../../controller/admin/index.php" method="post">
                <!--                    <div class="form-group">-->
                <!--                        <label for="exampleInputEmail1">Name</label>-->
                <!--                        <input type="name" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter name">-->
                <!--                    </div>-->
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="text-center">
                    <button type="submit" name="adminLogin" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <div class="col-sm" style="margin-top: 10px;">
                <?php if(isset($_GET['status'])): ?>
                    <div class="alert alert-warning">
                        <p><?php echo "Please fill the blanks!"; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-4"></div>
    </div>
</div>
</body>

<?php
require_once("footer.php");
?>
