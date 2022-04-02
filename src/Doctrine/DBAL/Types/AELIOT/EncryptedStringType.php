<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\AELIOT;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\EncryptedTypeEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EncryptedStringType extends StringType implements EncryptedFieldLengthInterface
{
    use EncryptionTrait;

    public function getDefaultFieldLength(AbstractPlatform $platform): ?int
    {
        return 255;
    }

    public function getName(): string
    {
        return EncryptedTypeEnum::AELIOT_ENCRYPTED_STRING;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL($fieldDeclaration);
    }
}
