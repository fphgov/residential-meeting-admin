<?php

declare(strict_types=1);

namespace App\Handler\Account;

use App\InputFilter\AccountSendFilter;
use App\Service\AccountServiceInterface;
use Laminas\InputFilter\InputFilterPluginManager;
use Psr\Container\ContainerInterface;

final class SendHandlerFactory
{
    public function __invoke(ContainerInterface $container): SendHandler
    {
        /** @var InputFilterPluginManager $pluginManager */
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(AccountSendFilter::class);

        return new SendHandler(
            $container->get(AccountServiceInterface::class),
            $inputFilter
        );
    }
}
