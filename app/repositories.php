<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Domain\Product\ProductRepository;
use App\Infrastructure\Persistence\Product\DoctrineProductRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(array(
        ProductRepository::class => \DI\autowire(DoctrineProductRepository::class),

        EntityManager::class => function (ContainerInterface $c){
            $settings = $c->get(SettingsInterface::class);
            $doctrineSettings = $settings->get('doctrine');
            $config = Setup::createConfiguration(
                $doctrineSettings['dev_mode'],
            );

            $config->setMetadataDriverImpl(
                new AnnotationDriver(
                   new Doctrine\Common\Annotations\AnnotationReader()
                )
            );

            return EntityManager::create(
                DriverManager::getConnection($doctrineSettings['connection']),
                $config
            );
        },
    ));
};
