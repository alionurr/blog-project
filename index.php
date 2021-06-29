<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/routes.php';
require_once __DIR__ . '/config/config.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$conn = Yaml::parse(file_get_contents('config/doctrine.yaml'));

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);


$loader = new FilesystemLoader(__DIR__.'/src/templates');
$twig = new Environment($loader);

$request = Request::createFromGlobals();


$className = "\\App\\Controller\\". $controller;
if(!class_exists($className)){
    throw new \Exception("Bulunamadı");
}
$class = new $className($request, $entityManager, $twig);
echo $class->{$method}(...$params);