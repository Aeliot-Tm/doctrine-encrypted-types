<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\EncryptedTypeEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateImmutableType;

final class EncryptedDateImmutableType extends DateImmutableType implements EncryptedFieldLengthInterface
{
    use EncryptionTrait;

    public function getDefaultFieldLength(AbstractPlatform $platform): ?int
    {
        return 255;
    }

    public function getName(): string
    {
        return EncryptedTypeEnum::AELIOT_ENCRYPTED_DATE_IMMUTABLE;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL($fieldDeclaration);
    }
}
