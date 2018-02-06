<?php
declare(strict_types=1);

namespace App\Test\Environment\Client;

use App\Client\MemcachedClient;
use App\Test\Environment\AppKernel;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Type;

class MemcachedClientTest extends TestCase
{
    use AppKernel;

    public function testConnectionSuccess()
    {
        /** @var MemcachedClient $client */
        $client = $this->container->get(MemcachedClient::class);

        $serverList = $client->getServerList();

        $this->assertNotEmpty($serverList);
    }

    public function testServersHasPositiveUpTime()
    {
        /** @var MemcachedClient $client */
        $client = $this->container->get(MemcachedClient::class);

        $serverList = $client->getServerList();
        $stats = $client->getStats();

        foreach ($serverList as $serverInfo) {
            $serverStat = $stats[sprintf('%s:%d', $serverInfo['host'] ?? '', $serverInfo['port'] ?? 0)] ?? [];
            $this->assertArrayHasKey('uptime', $serverStat);
            $this->assertGreaterThan(0, $serverStat['uptime']);
        }
    }
}
