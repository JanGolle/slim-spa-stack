<?php
declare(strict_types=1);

use App\Client\AMQPClient;
use App\Client\DoctrineConnection;
use App\Client\ElasticaClient;
use App\Client\MemcachedClient;
use App\Client\PredisClient;
use App\Service\Logger;
use Monolog\Handler\StreamHandler;
use Slim\Container;

/** @var Container $c */
$c = $app->getContainer();

$c->offsetSet(
    Logger::class,
    function (Container $c) {
        return new Logger(
            'API',
            [
                new StreamHandler(__DIR__ . '/../../logs/slimspa.log', Logger::DEBUG)
            ]
        );
    }
);

$c->offsetSet(
    ElasticaClient::class,
    $c->factory(
        function (Container $c) {
            return new ElasticaClient(
                [
                    'connections' => [
                        [
                            'host' => getenv('ELASTICSEARCH_HOST'),
                            'port' => getenv('ELASTICSEARCH_PORT'),
                        ]
                    ]
                ],
                null,
                $c->get(Logger::class)
            );
        }
    )
);

$c->offsetSet(
    PredisClient::class,
    function (Container $c) {
        return new PredisClient(
            [
                'host' => getenv('REDIS_HOST'),
                'port' => getenv('REDIS_PORT'),
            ]
        );
    }
);

$c->offsetSet(
    MemcachedClient::class,
    function (Container $c) {
        $client = new MemcachedClient();
        $client->addServer(
            getenv('MEMCACHED_HOST'),
            (int) getenv('MEMCACHED_PORT'),
            0
        );

        return $client;
    }
);

$c->offsetSet(
    AMQPClient::class,
    function (Container $c) {
        $client = new AMQPClient(
            getenv('RABBITMQ_HOST'),
            (int) getenv('RABBITMQ_PORT'),
            getenv('RABBITMQ_USER'),
            getenv('RABBITMQ_PASSWORD')
        );

        return $client;
    }
);

$c->offsetSet(
    DoctrineConnection::class,
    function (Container $c) {
        return \Doctrine\DBAL\DriverManager::getConnection(
            [
                'dbname' => getenv('MYSQL_DATABASE'),
                'user' => getenv('MYSQL_USER'),
                'password' => getenv('MYSQL_PASSWORD'),
                'host' => getenv('MYSQL_HOST'),
                'driver' => 'pdo_mysql',
                'wrapperClass' => DoctrineConnection::class
            ],
            new \Doctrine\DBAL\Configuration()
        );
    }
);
