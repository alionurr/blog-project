<?php
require_once __DIR__ . '/../../config.php';

    $sql = "SELECT b.*, COUNT(c.name) AS category FROM blog_category AS bc INNER JOIN category AS c ON c.id = bc.category_id INNER JOIN blog AS b ON b.id = bc.blog_id GROUP BY bc.blog_id";
//$ex = "SELECT
//                b.*
//            FROM
//                blog AS b
//            LEFT JOIN
//                blog_category AS bc ON
//                    b.id = bc.blog_id
//            LEFT JOIN
//                category AS c ON
//                    c.id = bc.category_id";

$posts = $conn->prepare($sql);
$posts->execute();

$blogs = $posts->fetchAll(PDO::FETCH_ASSOC);
//print_r($blogs);
//exit();

header('Content-Type: application/json');

echo json_encode($blogs);

