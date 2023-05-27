<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies'  => $this->getDependencies(),
            'input_filters' => $this->getInputFilters(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'delegators' => [],
            'factories'  => [
                Handler\Account\SearchHandler::class     => Handler\Account\SearchHandlerFactory::class,
                Handler\Account\SendHandler::class       => Handler\Account\SendHandlerFactory::class,
                Handler\Account\PrintHandler::class      => Handler\Account\PrintHandlerFactory::class,
                Handler\Account\RejectHandler::class     => Handler\Account\RejectHandlerFactory::class,
                Handler\Setting\GetHandler::class        => Handler\Setting\GetHandlerFactory::class,
                Service\AccountServiceInterface::class   => Service\AccountServiceFactory::class,
                Service\AuditLogServiceInterface::class  => Service\AuditLogServiceFactory::class,
                Service\MailQueueServiceInterface::class => Service\MailQueueServiceFactory::class,
                Service\UserServiceInterface::class      => Service\UserServiceFactory::class,
                Service\MailServiceInterface::class      => Service\MailServiceFactory::class,
                Helper\MailContentHelper::class          => Helper\MailContentHelperFactory::class,
                Helper\MailContentRawHelper::class       => Helper\MailContentRawHelperFactory::class,
            ],
        ];
    }

    public function getInputFilters(): array
    {
        return [
            'factories'  => [
            ],
            'invokables' => [
                InputFilter\AccountSearchFilter::class => InputFilter\AccountSearchFilter::class,
                InputFilter\AccountSendFilter::class   => InputFilter\AccountSendFilter::class,
                InputFilter\AccountRejectFilter::class => InputFilter\AccountRejectFilter::class,
            ],
        ];
    }
}
