<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

use Doctrine\DBAL\Connection;

final class DefaultEncryptionKeyProvider implements EncryptionKeyProviderInterface
{
    public function getSecret(string $connectionName): string
    {
        return (string) getenv('DB_ENCRYPTION_KEY');
    }

    public function prepareConnection(Connection $connection): void
    {
    }

    public function wrapParameter(string $sqlExpr): string
    {
        return $sqlExpr;
    }
}
