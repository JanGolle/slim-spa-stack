<?php
declare(strict_types=1);

namespace App\Test\Environment;

use JanGolle\SlimSymfonyContainer\Loader\ServiceInjectionLoader;
use JanGolle\SlimSymfonyContainer\Loader\SlimDefaultServicesInjection;
use Slim\App;
use Slim\Container;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Trait AppKernel
 */
trait AppKernel
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @before
     */
    protected function setUpAppKernel()
    {
        $container = new ContainerBuilder();

        $yamlLoader = new YamlFileLoader($container, new FileLocator(CONFIG_PATH));
        $yamlLoader->load('services.yaml');

        $injectionLoader = new ServiceInjectionLoader($container);
        $injectionLoader->load(new SlimDefaultServicesInjection());

        $container->compile(true);
        $app = new App($container);

        $this->app = $app;
        $this->container = $app->getContainer();
    }

    /**
     * @after
     */
    protected function tearDownAppKernel()
    {
        unset($this->app);
        unset($this->container);
    }
}
