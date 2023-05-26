<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

final class AuditLogServiceFactory
{
    public function __invoke(ContainerInterface $container): AuditLogService
    {
        $config = $container->has('config') ? $container->get('config') : [];

        return new AuditLogService(
            $config,
            $container->get(EntityManagerInterface::class)
        );
    }
}
