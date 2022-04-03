<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

use Doctrine\DBAL\Connection;

interface EncryptionKeyProviderInterface
{
    public function getSecret(string $connectionName): string;

    public function prepareConnection(Connection $connection): void;

    public function wrapParameter(string $sqlExpr): string;
}
