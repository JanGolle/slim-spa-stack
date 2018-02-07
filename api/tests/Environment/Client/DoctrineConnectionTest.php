<?php
declare(strict_types=1);

namespace App\Test\Environment\Client;

use App\Client\DoctrineConnection;
use App\Test\Environment\AppKernel;
use PHPUnit\Framework\TestCase;

/**
 * Class DoctrineConnectionTest
 */
class DoctrineConnectionTest extends TestCase
{
    use AppKernel;

    public function testConnectionSuccess()
    {
        /** @var DoctrineConnection $connection */
        $connection = $this->container->get(DoctrineConnection::class);

        $this->assertTrue($connection->ping());
    }
}
