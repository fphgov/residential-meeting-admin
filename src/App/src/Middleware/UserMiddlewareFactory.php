<?php

declare(strict_types=1);

namespace App\Middleware;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class UserMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): UserMiddleware
    {
        return new UserMiddleware(
            $container->get(EntityManagerInterface::class)
        );
    }
}
