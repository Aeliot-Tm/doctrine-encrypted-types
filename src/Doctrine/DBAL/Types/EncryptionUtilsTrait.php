<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;

trait EncryptionUtilsTrait
{
    private function getEncryptSQLExpression(string $sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('%s(%s)', FunctionEnum::FUNCTION_ENCRYPT, $this->normalizeSqlExpr($sqlExpr));
    }

    private function getDecryptSQLExpression(string $sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('%s(%s)', FunctionEnum::FUNCTION_DECRYPT, $this->normalizeSqlExpr($sqlExpr));
    }

    private function normalizeSqlExpr(string $sqlExpr): string
    {
        return $sqlExpr ?: 'NULL';
    }
}
