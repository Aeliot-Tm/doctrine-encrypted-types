<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FieldTypeEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateImmutableType;

final class EncryptedDateImmutableType extends DateImmutableType implements EncryptedFieldLengthInterface
{
    use ValueConversionTrait;

    public function getDefaultFieldLength(AbstractPlatform $platform): ?int
    {
        return 255;
    }

    public function getName(): string
    {
        return FieldTypeEnum::AELIOT_ENCRYPTED_DATE_IMMUTABLE;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL($fieldDeclaration);
    }
}
