<?php

declare(strict_types=1);

namespace App\Service;

use App\Middleware\AuditMiddleware;
use App\Service\MailServiceInterface;
use App\Service\AuditLogServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Pdf\Interfaces\PdfRender;

final class AccountServiceFactory
{
    public function __invoke(ContainerInterface $container): AccountService
    {
        $config = $container->has('config') ? $container->get('config') : [];

        return new AccountService(
            $config,
            $container->get(EntityManagerInterface::class),
            $container->get(AuditMiddleware::class)->getLogger(),
            $container->get(MailServiceInterface::class),
            $container->get(AuditLogServiceInterface::class),
            $container->get(PdfRender::class)
        );
    }
}
