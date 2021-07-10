<?php
require_once __DIR__ . '/bootstrap.php';
use App\Framework\Container;


$className = "\\App\\Controller\\". $controller;
if(!class_exists($className)){
    throw new \Exception("Bulunamadı");
}
$container = new Container();
$container->register('request', $request);
$container->register('entity_manager', $entityManager);
$container->register('twig', $twig);

$securityService = new \App\Service\Admin\SecurityService($entityManager);
$container->register(\App\Service\Admin\SecurityService::class, $securityService);

$postService = new \App\Service\Admin\PostService($entityManager);
$container->register(\App\Service\Admin\PostService::class,$postService);

$categoryService = new \App\Service\Admin\CategoryService($entityManager);
$container->register(\App\Service\Admin\CategoryService::class,$categoryService);

try{
    $class = new $className($container);
    echo $class->{$method}(...$params);
}catch (Throwable $exception){
    echo ($exception->getMessage());exit;
}
