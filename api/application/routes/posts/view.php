<?php
declare(strict_types=1);

/** @var \Slim\App $app */

use Slim\Http\Request;
use Slim\Http\Response;

$app->get(
    '/posts/{id:\d+}',
    function (Request $request, Response $response, array $args) {
        $response = $response->withJson(
            [
                'data' => [
                    'title' => 'Post #' . $args['id'],
                    'tag' => 'slim',
                    'description' => 'Post description',
                ],
                'meta' => [
                ],
                'success' => true,
            ],
            200,
            JSON_PRETTY_PRINT
        );

        return $response;
    }
);

