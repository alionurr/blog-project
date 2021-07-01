<?php

$servername = "localhost";
$username = "root";
$password = "root";

session_start();

const ROOT = __DIR__;
try {
    $conn = new PDO("mysql:host=$servername;dbname=oop_blog", $username, $password);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
