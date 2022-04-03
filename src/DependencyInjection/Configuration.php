<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\DependencyInjection;

use Aeliot\Bundle\DoctrineEncryptedField\Service\DefaultEncryptionAvailabilityChecker;
use Aeliot\Bundle\DoctrineEncryptedField\Service\DefaultEncryptionKeyProvider;
use Aeliot\Bundle\DoctrineEncryptedField\Service\DefaultFunctionProvider;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('aeliot_doctrine_encrypted_field');

        $rootNode
            ->children()
                ->arrayNode('encrypted_connections')
                    ->beforeNormalization()
                        ->ifEmpty()
                        ->thenEmptyArray()
                    ->end()
                    ->beforeNormalization()
                        ->castToArray()
                    ->end()
                    ->scalarPrototype()
                    ->end()
                    ->defaultValue(['default'])
                ->end()
                ->scalarNode('encryption_availability_checker')
                    ->cannotBeEmpty()
                    ->defaultValue(DefaultEncryptionAvailabilityChecker::class)
                ->end()
                ->scalarNode('encryption_key_provider')
                    ->cannotBeEmpty()
                    ->defaultValue(DefaultEncryptionKeyProvider::class)
                ->end()
                ->scalarNode('functions_provider')
                    ->cannotBeEmpty()
                    ->defaultValue(DefaultFunctionProvider::class)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
