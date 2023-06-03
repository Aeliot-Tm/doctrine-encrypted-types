<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;

trait ValueConversionTrait
{
    use EncryptionUtilsTrait;

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    /**
     * @param string $sqlExpr
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform): string
    {
        return $this->getEncryptSQLExpression($sqlExpr, $platform);
    }

    /**
     * @param string $sqlExpr
     * @param AbstractPlatform $platform
     */
    public function convertToPHPValueSQL($sqlExpr, $platform): string
    {
        return $this->getDecryptSQLExpression($sqlExpr, $platform);
    }
}
