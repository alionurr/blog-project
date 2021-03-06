<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

//$paths = "/home/web/blog/src/";

$paths = [__DIR__."/src/"];
//var_dump($paths);exit();
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => 'root',
    'dbname'   => 'Blog_Project',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

//var_dump($config);exit();
//$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);





//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "root";

const ROOT = __DIR__;
try {
    $conn = new PDO("mysql:host=$servername;dbname=Blog_Project", $username, $password);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if(session_status() === PHP_SESSION_NONE){
    session_start();
//    session_destroy();
}
$requestUri = $_SERVER['REQUEST_URI'];
if(strpos($requestUri, '/views/admin') === 0 && !in_array($requestUri, ['/views/admin/login.php', '/views/admin/logout.php']))
{
    if (!isset($_SESSION["name"]))
    {
        // giriş yapmaya çalışıyor
        Header("Location:/views/admin/login.php");
    }
}

$numperpage = 9;


//$a = $_SERVER;

// if(!isset($_SESSION['name'])) {
//    header("Location: /views/login.php");
//}


?>