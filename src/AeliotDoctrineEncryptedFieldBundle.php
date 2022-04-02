<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField;

use Aeliot\Bundle\DoctrineEncryptedField\DependencyInjection\Compiler\EnableEncryptionSQLWalkerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AeliotDoctrineEncryptedFieldBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new EnableEncryptionSQLWalkerCompilerPass());
    }
}

