<?php
$servername = "localhost";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=Blog_Project", $username, $password);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>