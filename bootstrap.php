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
use Twig\TwigFunction;



// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$conn = Yaml::parse(file_get_contents('config/doctrine.yaml'));

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

$loader = new FilesystemLoader(__DIR__.'/src/templates/admin');
$twig = new Environment($loader);

$getName = new TwigFunction('getName', function (){
    if (isset($_SESSION['adminName'])):
        echo $_SESSION['adminName'];
    else:
        echo "logout";
    endif;
});

$twig->addFunction($getName);

//new \App\Service\Twig\TwigService($twig);


$request = Request::createFromGlobals();

// security sınıfının methodu çağırılmalı
//$securityHandler = new \App\Framework\SecurityHandler();
//$securityHandler->run($request);