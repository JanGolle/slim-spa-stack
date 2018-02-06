<?php
declare(strict_types=1);

namespace App\Test\Environment;

use Slim\App;
use Slim\Container;

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
        $app = new App();

        require DEPENDENCIES_PATH;

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
