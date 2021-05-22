<?php

namespace Aeliot\Bundle\EncryptDB\DependencyInjection;

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
            ->end();

        return $treeBuilder;
    }
}
