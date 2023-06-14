<?php

declare(strict_types=1);

namespace App\Handler\Stat;

use App\Model\MailLogExportModel;
use Psr\Container\ContainerInterface;

final class GetMailHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetMailHandler
    {
        return new GetMailHandler(
            $container->get(MailLogExportModel::class)
        );
    }
}
