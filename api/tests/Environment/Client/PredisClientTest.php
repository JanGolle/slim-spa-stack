<?php
declare(strict_types=1);

namespace App\Test\Environment\Client;

use App\Client\PredisClient;
use App\Test\Environment\AppKernel;
use PHPUnit\Framework\TestCase;
use Predis\Response\Status;

/**
 * Class PredisClientTest
 */
class PredisClientTest extends TestCase
{
    use AppKernel;

    public function testConnectionSuccess()
    {
        /** @var PredisClient $client */
        $client = $this->container->get(PredisClient::class);

        $status = $client->ping();

        $this->assertInstanceOf(Status::class, $status);
        $this->assertEquals('PONG', (string) $status);
    }
}
