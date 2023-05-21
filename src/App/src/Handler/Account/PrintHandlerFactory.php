<?php

declare(strict_types=1);

namespace App\Handler\Account;

use App\InputFilter\AccountPrintFilter;
use App\Service\AccountServiceInterface;
use Laminas\InputFilter\InputFilterPluginManager;
use Psr\Container\ContainerInterface;

final class PrintHandlerFactory
{
    public function __invoke(ContainerInterface $container): PrintHandler
    {
        /** @var InputFilterPluginManager $pluginManager */
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(AccountPrintFilter::class);

        return new PrintHandler(
            $container->get(AccountServiceInterface::class),
            $inputFilter
        );
    }
}
