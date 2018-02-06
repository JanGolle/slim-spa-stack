<?php
declare(strict_types=1);

namespace App\Test\Environment\Client;

use App\Client\ElasticaClient;
use App\Test\Environment\AppKernel;
use PHPUnit\Framework\TestCase;

/**
 * Class ElasticaClientTest
 */
class ElasticaClientTest extends TestCase
{
    use AppKernel;

    public function testClusterHasGreenStatus()
    {
        /** @var ElasticaClient $client */
        $client = $this->container->get(ElasticaClient::class);

        $status = $client->getCluster()->getHealth()->getStatus();

        $this->assertEquals('green', $status);
    }
}
