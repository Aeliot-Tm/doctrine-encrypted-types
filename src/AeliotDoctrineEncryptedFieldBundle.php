<?php

namespace Aeliot\Bundle\DoctrineEncryptedField;

use Aeliot\Bundle\DoctrineEncryptedField\DependencyInjection\Compiler\EnableEncryptionSQLWalkerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AeliotDoctrineEncryptedFieldBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new EnableEncryptionSQLWalkerCompilerPass());
    }
}

