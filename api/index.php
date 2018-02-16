<?php
declare(strict_types=1);

use Slim\App;

require __DIR__ . '/bootstrap.php';

$app = new App($container);

$routesIterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__ . '/application/routes', RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($routesIterator as $route) {
    require $route;
}

$app->run();
