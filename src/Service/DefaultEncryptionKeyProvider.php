<?php

namespace Aeliot\Bundle\EncryptDB\Service;

use Doctrine\DBAL\Connection;

class DefaultEncryptionKeyProvider implements EncryptionKeyProviderInterface
{
    public function getSecret(string $connectionName): string
    {
        return (string) getenv('DB_ENCRYPTION_KEY');
    }

    /**
     * @return void
     */
    public function prepareConnection(Connection $connection)
    {
    }

    public function wrapParameter(string $sqlExpr): string
    {
        return $sqlExpr;
    }
}
