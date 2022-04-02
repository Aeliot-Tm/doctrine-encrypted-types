<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\DependencyInjection;

use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\AELIOT\EncryptedDateImmutableType;
use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\AELIOT\EncryptedDateTimeImmutableType;
use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\AELIOT\EncryptedDateTimeType;
use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\AELIOT\EncryptedDateType;
use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\AELIOT\EncryptedStringType;
use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\ORM\Query\AST\Functions\AELIOT\DecryptFunction;
use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\ORM\Query\AST\Functions\AELIOT\EncryptFunction;
use Aeliot\Bundle\DoctrineEncryptedField\Enum\EncryptedTypeEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Service\EncryptionAvailabilityCheckerInterface;
use Aeliot\Bundle\DoctrineEncryptedField\Service\EncryptionKeyProviderInterface;
use Aeliot\Bundle\DoctrineEncryptedField\Service\FunctionProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AeliotDoctrineEncryptedFieldExtension extends Extension implements PrependExtensionInterface
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

        $container->setParameter('aeliot.doctrine_encrypted_field.encrypted_connections', $config['encrypted_connections']);

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
                        EncryptedTypeEnum::AELIOT_ENCRYPTED_DATE => EncryptedDateType::class,
                        EncryptedTypeEnum::AELIOT_ENCRYPTED_DATE_IMMUTABLE => EncryptedDateImmutableType::class,
                        EncryptedTypeEnum::AELIOT_ENCRYPTED_DATETIME => EncryptedDateTimeType::class,
                        EncryptedTypeEnum::AELIOT_ENCRYPTED_DATETIME_IMMUTABLE => EncryptedDateTimeImmutableType::class,
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
