<?php

declare(strict_types=1);

namespace Aeliot\Bundle\EncryptDB\Doctrine\DBAL\Types\AELIOT;

use Doctrine\DBAL\Platforms\AbstractPlatform;

trait EncryptionTrait
{
    use EncryptionUtilsTrait;

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    /**
     * @param string $sqlExpr
     *
     * @return string
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return $this->getEncryptSQLExpression($sqlExpr, $platform);
    }

    /**
     * @param string $sqlExpr
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToPHPValueSQL($sqlExpr, $platform)
    {
        return $this->getDecryptSQLExpression($sqlExpr, $platform);
    }
}