<?php
declare(strict_types=1);

use JanGolle\SlimSymfonyContainer\Loader\ServiceInjectionLoader;
use JanGolle\SlimSymfonyContainer\Loader\SlimDefaultServicesInjection;
use Slim\App;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__ . '/vendor/autoload.php';

define('DEBUG', in_array(getenv('DEV_STAGE'), ['dev', 'test']) || ($_COOKIE['debug_mode'] ?? 0 === 1));
define('PROJECT_PATH', __DIR__);

$container = new ContainerBuilder();

$yamlLoader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/application/config'));
$yamlLoader->load('services.yaml');

$injectionLoader = new ServiceInjectionLoader($container);
$injectionLoader->load(new SlimDefaultServicesInjection());

$container->compile(true);
$app = new App($container);

$routesIterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__ . '/application/routes', RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($routesIterator as $route) {
    require $route;
}

$app->run();
