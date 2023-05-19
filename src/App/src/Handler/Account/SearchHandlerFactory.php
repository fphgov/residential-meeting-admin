<?php

declare(strict_types=1);

namespace App\Handler\Account;

use App\InputFilter\AccountSearchFilter;
use App\Service\AccountServiceInterface;
use Laminas\InputFilter\InputFilterPluginManager;
use Psr\Container\ContainerInterface;

final class SearchHandlerFactory
{
    public function __invoke(ContainerInterface $container): SearchHandler
    {
        /** @var InputFilterPluginManager $pluginManager */
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(AccountSearchFilter::class);

        return new SearchHandler(
            $container->get(AccountServiceInterface::class),
            $inputFilter
        );
    }
}
