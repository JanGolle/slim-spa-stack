<?php
declare(strict_types=1);

/** @var \Slim\App $app */

use App\Entity\Post;
use App\Service\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$app->get(
    '/posts/{id:\d+}',
    function (Request $request, Response $response, array $args) {
        /** @var ContainerBuilder $this */
        $postRepository = $this->get(EntityManager::class)->getRepository(Post::class);
        $post = $postRepository->findOneBy(['id' => (int) $args['id']]);

        $response = $response->withJson(
            [
                'data' => !is_null($post)
                    ? [
                        'id' => $post->getId(),
                        'title' => $post->getTitle(),
                        'author' => $post->getAuthor()->getEmail(),
                        'createdAt' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                    ] : [],
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

