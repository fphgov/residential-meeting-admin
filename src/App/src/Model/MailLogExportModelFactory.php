<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

final class MailLogExportModelFactory
{
    /**
     * @return MailLogExportModel
     */
    public function __invoke(ContainerInterface $container)
    {
        return new MailLogExportModel(
            $container->get(EntityManagerInterface::class)
        );
    }
}
