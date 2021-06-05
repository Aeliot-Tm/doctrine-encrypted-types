<?php

namespace Aeliot\Bundle\EncryptDB\DependencyInjection;

use Aeliot\Bundle\EncryptDB\Doctrine\DBAL\Types\AELIOT\EncryptedDateTimeType;
use Aeliot\Bundle\EncryptDB\Doctrine\DBAL\Types\AELIOT\EncryptedStringType;
use Aeliot\Bundle\EncryptDB\Doctrine\ORM\Query\AST\Functions\AELIOT\DecryptFunction;
use Aeliot\Bundle\EncryptDB\Doctrine\ORM\Query\AST\Functions\AELIOT\EncryptFunction;
use Aeliot\Bundle\EncryptDB\Enum\EncryptedTypeEnum;
use Aeliot\Bundle\EncryptDB\Enum\FunctionEnum;
use Aeliot\Bundle\EncryptDB\Service\EncryptionAvailabilityCheckerInterface;
use Aeliot\Bundle\EncryptDB\Service\EncryptionKeyProviderInterface;
use Aeliot\Bundle\EncryptDB\Service\FunctionProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AeliotEncryptDBExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setAlias(
            EncryptionAvailabilityCheckerInterface::class,
            new Alias($config['encryption_availability_checker'])
        );
        $container->setAlias(EncryptionKeyProviderInterface::class, new Alias($config['encryption_key_provider']));
        $container->setAlias(FunctionProviderInterface::class, new Alias($config['functions_provider']));

        $container->setParameter('aeliot.aeliot_encrypt_db.encrypted_connections', $config['encrypted_connections']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $this->prependDoctrineConfig($container);
    }

    private function prependDoctrineConfig(ContainerBuilder $container)
    {
        $container->prependExtensionConfig(
            'doctrine',
            [
                'dbal' => [
                    'types' => [
                        EncryptedTypeEnum::AELIOT_ENCRYPTED_DATETIME => EncryptedDateTimeType::class,
                        EncryptedTypeEnum::AELIOT_ENCRYPTED_STRING => EncryptedStringType::class,
                    ],
                ],
                'orm' => [
                    'dql' => [
                        'string_functions' => [
                            FunctionEnum::FUNCTION_DECRYPT => DecryptFunction::class,
                            FunctionEnum::FUNCTION_ENCRYPT => EncryptFunction::class,
                        ],
                    ],
                ],
            ]
        );
    }
}
