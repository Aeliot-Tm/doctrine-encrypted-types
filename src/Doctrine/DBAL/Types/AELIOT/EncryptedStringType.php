<?php

namespace Aeliot\Bundle\EncryptDB\Doctrine\DBAL\Types\AELIOT;

use Aeliot\Bundle\EncryptDB\Enum\EncryptedTypeEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EncryptedStringType extends StringType
{
    public function getName(): string
    {
        return EncryptedTypeEnum::AELIOT_ENCRYPTED_STRING;
    }

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    /**
     * @param string           $sqlExpr
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return sprintf('AELIOT_ENCRYPT(%s)', $sqlExpr ?: 'NULL');
    }

    /**
     * @param string           $sqlExpr
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToPHPValueSQL($sqlExpr, $platform)
    {
        return sprintf('AELIOT_DECRYPT(%s)', $sqlExpr ?: 'NULL');
    }
}
