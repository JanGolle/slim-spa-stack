<?php
declare(strict_types=1);

/** @var \Slim\App $app */

use App\Entity\Post;
use App\Service\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$app->get(
    '/posts',
    function (Request $request, Response $response, array $args) {
        /** @var ContainerBuilder $this */
        $postRepository = $this->get(EntityManager::class)->getRepository(Post::class);

        $limit = (int) $request->getParam('limit', 10);
        $offset = (int) $request->getParam('offset', 0);

        $posts = $postRepository->findBy([], null, $limit, $offset);
        $totalCount = $postRepository->count([]);

        $response = $response->withJson(
            [
                'data' => array_map(
                    function (Post $post) {
                        return [
                            'id' => $post->getId(),
                            'title' => $post->getTitle(),
                            'author' => $post->getAuthor()->getEmail(),
                            'createdAt' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                        ];
                    },
                    $posts
                ),
                'meta' => [
                    'pagination' => [
                        'limit' => $limit,
                        'offset' => $offset,
                        'total' => $totalCount,
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

