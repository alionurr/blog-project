<?php require_once("header.php"); ?>

<body>
<?php require_once ("navbar.php"); ?>

<?php
if (isset($_POST['searchButton']))
{
    $search = $_POST['search'];

    $searchKeyword = $conn->prepare("SELECT * FROM blog WHERE title LIKE '%$search%' OR excerpt LIKE '%$search%' OR content LIKE '%$search%'");
    $searchKeyword->execute();
    $result = $searchKeyword->fetchAll(PDO::FETCH_ASSOC);
    print_r($result);exit();

}


?>


</body>

<?php require_once ("footer.php"); ?>

