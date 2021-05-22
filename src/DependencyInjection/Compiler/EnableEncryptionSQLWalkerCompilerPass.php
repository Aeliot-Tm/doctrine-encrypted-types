<?php

namespace Aeliot\Bundle\EncryptDB\DependencyInjection\Compiler;

use Aeliot\Bundle\EncryptDB\Doctrine\ORM\Query\EncryptionSQLWalker;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EnableEncryptionSQLWalkerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $connections = $container->getParameter('aeliot.aeliot_encrypt_db.encrypted_connections');
        foreach ($connections as $connection) {
            $ormConfiguration = $container->getDefinition(sprintf('doctrine.orm.%s_configuration', $connection));
            $ormConfiguration->addMethodCall('setDefaultQueryHint', [
                Query::HINT_CUSTOM_OUTPUT_WALKER,
                EncryptionSQLWalker::class
            ]);
        }
    }
}
