<?php
require_once("header.php");
//print_r($_SESSION);
?>

<body>
    <div class="container">
        <h1><span class="text-uppercase"><?= $_SESSION['name'] ?></span>, Welcome to our Blog </h1>
    </div>
</body>

<?php
require_once("footer.php");
?>