<?php

declare(strict_types=1);

namespace App\Service;

use App\Middleware\AuditMiddleware;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

final class UserServiceFactory
{
    /**
     * @return UserService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new UserService(
            $container->get(EntityManagerInterface::class),
            $container->get(AuditMiddleware::class)->getLogger()
        );
    }
}
