<?php
declare(strict_types=1);

use App\Client\ElasticaClient;
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
                            'host' => 'elasticsearch'
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
                'host' => 'redis',
                'port' => 6379
            ]
        );
    }
);
