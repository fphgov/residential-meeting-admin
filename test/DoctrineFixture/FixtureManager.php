<?php

declare(strict_types=1);

namespace DoctrineFixture;

use App\Entity;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Ramsey\Uuid\Doctrine\UuidType;

use function dirname;

final class FixtureManager
{
    public static function getEntityManager(): EntityManagerInterface
    {
        $isDevMode = true;

        $paths = [
            dirname(__DIR__, 2) . '/src/App/src/Entity',
        ];

        $connectionParams = [
            'driver' => 'pdo_sqlite',
            'url'    => 'sqlite:////usr/local/var/db.sqlite',
        ];

        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);

        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        $eventManager = new EventManager();
        $rtel         = new ResolveTargetEntityListener();

        $rtel->addResolveTargetEntity(Entity\SettingsInterface::class, Entity\Settings::class, []);
        $rtel->addResolveTargetEntity(Entity\UserInterface::class, Entity\User::class, []);

        $eventManager->addEventListener(Events::loadClassMetadata, $rtel);

        return EntityManager::create($connectionParams, $config, $eventManager);
    }

    public static function start(): void
    {
        $em = static::getEntityManager();

        $schemaTool = new SchemaTool(static::getEntityManager());
        $metadatas  = static::getEntityManager()
                            ->getMetadataFactory()
                            ->getAllMetadata();

        if (Type::hasType(UuidType::NAME) === false) {
            Type::addType(UuidType::NAME, UuidType::class);

            $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('db_uuid', UuidType::NAME);
        }

        $schemaTool->dropSchema($metadatas);
        $schemaTool->createSchema($metadatas);
    }

    public static function getFixtureExecutor(): ORMExecutor
    {
        return new ORMExecutor(
            static::getEntityManager(),
            new ORMPurger(static::getEntityManager())
        );
    }
}
