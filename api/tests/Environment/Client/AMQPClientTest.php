<?php
declare(strict_types=1);

namespace App\Test\Environment\Client;

use App\Client\AMQPClient;
use App\Test\Environment\AppKernel;
use PHPUnit\Framework\TestCase;

/**
 * Class AMQPClientTest
 */
class AMQPClientTest extends TestCase
{
    use AppKernel;

    public function testConnectionSuccess()
    {
        /** @var AMQPClient $client */
        $client = $this->container->get(AMQPClient::class);

        $this->assertInternalType('array', $client->getConnection()->getServerProperties());
    }
}
