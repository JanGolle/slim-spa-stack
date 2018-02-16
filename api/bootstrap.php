<?php
declare(strict_types=1);

use Doctrine\Common\Annotations\AnnotationRegistry;
use JanGolle\SlimSymfonyContainer\Loader\ServiceInjectionLoader;
use JanGolle\SlimSymfonyContainer\Loader\SlimDefaultServicesInjection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$loader = require __DIR__ . '/vendor/autoload.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

define('DEBUG', in_array(getenv('DEV_STAGE'), ['dev', 'test']) || ($_COOKIE['debug_mode'] ?? 0 === 1));
define('PROJECT_PATH', __DIR__);

$container = new ContainerBuilder();

$yamlLoader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/application/config'));
$yamlLoader->load('services.yaml');

$injectionLoader = new ServiceInjectionLoader($container);
$injectionLoader->load(new SlimDefaultServicesInjection());

$container->compile(true);
