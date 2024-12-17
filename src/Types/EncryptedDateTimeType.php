<?php

declare(strict_types=1);

/*
 * This file is part of the Doctrine Encrypted Types.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\DoctrineEncryptedTypes\Types;

use Aeliot\DoctrineEncrypted\Contracts\ColumnDefaultLengthProviderInterface;
use Aeliot\DoctrineEncryptedTypes\Enum\FieldTypeEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

final class EncryptedDateTimeType extends DateTimeType implements ColumnDefaultLengthProviderInterface
{
    use ValueConversionTrait;

    public function getDefaultColumnLength(AbstractPlatform $platform): ?int
    {
        return 255;
    }

    public function getName(): string
    {
        return FieldTypeEnum::ENCRYPTED_DATETIME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL($column);
    }
}
