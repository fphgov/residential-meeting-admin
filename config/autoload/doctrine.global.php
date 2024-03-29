<?php

declare(strict_types=1);

use DoctrineExtensions\Query\Mysql;
use Ramsey\Uuid\Doctrine\UuidType;

return [
    'doctrine' => [
        'types'            => [
            UuidType::NAME => UuidType::class,
        ],
        'configuration' => [
            'orm_default' => [
                'string_functions' => [
                    'IF'           => Mysql\IfElse::class,
                    'GROUP_CONCAT' => Mysql\GroupConcat::class,
                    'DATE_FORMAT'  => Mysql\DateFormat::class,
                    'CONCAT_WS'    => Mysql\ConcatWs::class,
                    'NOW'          => Mysql\Now::class,
                ],
                'datetime_functions' => [
                    'DATE_SUB' => Mysql\DateSub::class,
                ],
                'numeric_functions' => [
                    'RAND' => Mysql\Rand::class,
                ]
            ]
        ],
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url'           => 'mysql://'. getenv('DB_USER') .':'. getenv('DB_PASSWORD') .'@'. getenv('DB_HOSTNAME') . ':' . (int)str_replace(['"',"'"], "", getenv('DB_PORT')) . '/' . getenv('DB_DATABASE'),
                    'charset'       => getenv('DB_CHARSET'),
                    'configuration' => []
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'my_entity',
                ],
            ],
            'my_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../../src/App/src/Entity'],
            ],
        ],
    ]
];
