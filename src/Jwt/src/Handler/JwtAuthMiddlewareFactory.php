<?php

declare(strict_types=1);

namespace Jwt\Handler;

use Psr\Container\ContainerInterface;
use RuntimeException;
use Tuupola\Middleware\JwtAuthentication;

use function getenv;

class JwtAuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): JwtAuthMiddleware
    {
        $config = $container->has('config') ? $container->get('config') : [];

        if (! isset($config['jwt'])) {
            throw new RuntimeException('Missing JWT configuration');
        }

        $auth = new JwtAuthentication([
            "secure"    => getenv('NODE_ENV') !== 'development' && $config['jwt']['auth']['secret'],
            "secret"    => $config['jwt']['auth']['secret'],
            "attribute" => JwtAuthMiddleware::class,
            "error" => function ($response, $arguments) {
                $data["status"] = "error";
                $data["message"] = $arguments["message"];

                $response->getBody()->write(
                    json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
                );

                return $response->withHeader("Content-Type", "application/json");
            }
        ]);

        return new JwtAuthMiddleware(
            $auth
        );
    }
}
