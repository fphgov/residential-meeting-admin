<?php

declare(strict_types=1);

namespace App\Handler\Account;

use App\InputFilter\AccountRejectFilter;
use App\Service\AccountServiceInterface;
use Laminas\InputFilter\InputFilterPluginManager;
use Psr\Container\ContainerInterface;

final class RejectHandlerFactory
{
    public function __invoke(ContainerInterface $container): RejectHandler
    {
        /** @var InputFilterPluginManager $pluginManager */
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(AccountRejectFilter::class);

        return new RejectHandler(
            $container->get(AccountServiceInterface::class),
            $inputFilter
        );
    }
}
