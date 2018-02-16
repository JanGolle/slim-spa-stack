<?php
declare(strict_types=1);

use App\Service\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . '/bootstrap.php';

return ConsoleRunner::createHelperSet($container->get(EntityManager::class));
