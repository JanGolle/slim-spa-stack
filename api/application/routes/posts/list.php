<?php
declare(strict_types=1);

/** @var \Slim\App $app */

use Slim\Http\Request;
use Slim\Http\Response;

$app->get(
    '/posts',
    function (Request $request, Response $response, array $args) {
        $response = $response->withJson(
            [
                'data' => [
                    [
                        'title' => 'Post #1',
                        'tag' => 'slim',
                        'description' => 'Post description',
                    ],
                    [
                        'title' => 'Post #2',
                        'tag' => 'spa',
                        'description' => 'Post description',
                    ],
                ],
                'meta' => [
                    'pagination' => [
                        'limit' => 10,
                        'offset' => 0,
                        'total' => 2,
                    ],
                ],
                'success' => true,
            ],
            200,
            JSON_PRETTY_PRINT
        );

        return $response;
    }
);

