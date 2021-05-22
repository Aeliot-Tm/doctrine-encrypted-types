<?php

namespace Aeliot\Bundle\EncryptDB\Doctrine\DBAL\Types\AELIOT;

use Doctrine\DBAL\Platforms\AbstractPlatform;

trait EncryptionUtilsTrait
{
    private function getEncryptSQLExpression(string $sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('AELIOT_ENCRYPT(%s)', $sqlExpr ?: 'NULL');
    }

    private function getDecryptSQLExpression(string $sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('AELIOT_DECRYPT(%s)', $sqlExpr ?: 'NULL');
    }
}
