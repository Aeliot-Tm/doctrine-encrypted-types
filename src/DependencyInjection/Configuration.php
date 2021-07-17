<?php

namespace Aeliot\Bundle\EncryptDB\DependencyInjection;

use Aeliot\Bundle\EncryptDB\Service\DefaultEncryptionAvailabilityChecker;
use Aeliot\Bundle\EncryptDB\Service\DefaultFunctionProvider;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('aeliot_encrypt_db');

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
                    ->isRequired()
                ->end()
                ->scalarNode('functions_provider')
                    ->cannotBeEmpty()
                    ->defaultValue(DefaultFunctionProvider::class)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
