<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace this with the path to your own project bootstrap file.
require_once __DIR__.'/bootstrap.php';
// replace with mechanism to retrieve EntityManager in your app
//$entityManager = GetEntityManager();

return ConsoleRunner::createHelperSet($entityManager);