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

$blogCreatorService = new \App\Service\Admin\CRUD\Creator\BlogCreator($entityManager);
$container->register(\App\Service\Admin\CRUD\Creator\BlogCreator::class, $blogCreatorService);

$categoryCreatorService = new \App\Service\Admin\CRUD\Creator\CategoryCreator($entityManager);
$container->register(\App\Service\Admin\CRUD\Creator\CategoryCreator::class,$categoryCreatorService);

$blogDeleterService = new \App\Service\Admin\CRUD\Deleter\BlogDeleter($entityManager);
$container->register(\App\Service\Admin\CRUD\Deleter\BlogDeleter::class, $blogDeleterService);

$blogFetcherService = new \App\Service\Admin\CRUD\Fetcher\BlogFetcher($entityManager);
$container->register(\App\Service\Admin\CRUD\Fetcher\BlogFetcher::class, $blogFetcherService);

$categoryFetcherService = new \App\Service\Admin\CRUD\Fetcher\CategoryFetcher($entityManager);
$container->register(\App\Service\Admin\CRUD\Fetcher\CategoryFetcher::class, $categoryFetcherService);



try{
    $class = new $className($container);
    echo $class->{$method}(...$params);
}catch (Throwable $exception){
    echo ($exception->getMessage());exit;
}
