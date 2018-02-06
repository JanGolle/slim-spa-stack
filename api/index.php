<?php
declare(strict_types=1);

use Slim\App;

require __DIR__ . '/vendor/autoload.php';

define('DEBUG', in_array(getenv('DEV_STAGE'), ['dev', 'test']) || ($_COOKIE['debug_mode'] ?? 0 === 1));
define('PROJECT_PATH', __DIR__ . '/api/');

/** @var App $this */
$app = new App(require __DIR__ . '/application/config/settings.php');

require __DIR__ . '/application/config/dependencies.php';

$routesIterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__ . '/application/routes', RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($routesIterator as $route) {
    require $route;
}

$app->run();
