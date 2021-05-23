<?php

namespace Aeliot\Bundle\EncryptDB\DependencyInjection;

use Aeliot\Bundle\EncryptDB\Service\EncryptionKeyProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AeliotEncryptDBExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setAlias(EncryptionKeyProviderInterface::class, new Alias($config['encryption_key_provider']));

        $container->setParameter('aeliot.aeliot_encrypt_db.encrypted_connections', $config['encrypted_connections']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
