<?php

namespace Aeliot\Bundle\EncryptDB;

use Aeliot\Bundle\EncryptDB\DependencyInjection\Compiler\EnableEncryptionSQLWalkerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AeliotEncryptDBBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new EnableEncryptionSQLWalkerCompilerPass());
    }
}

