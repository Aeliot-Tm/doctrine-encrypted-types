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

namespace Aeliot\DoctrineEncryptedTypes\Tests\Unit\Types;

use Aeliot\DoctrineEncryptedTypes\Enum\TypeEnum;
use Aeliot\DoctrineEncryptedTypes\Types\EncryptedDateTimeImmutableType;

final class EncryptedDateTimeImmutableTypeTest extends AbstractTypeTestCase
{
    public function testCanRequireSQLConversion(): void
    {
        $encryptedType = new EncryptedDateTimeImmutableType();
        self::assertTrue($encryptedType->canRequireSQLConversion());
    }

    public function testConvertToDatabaseValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedDateTimeImmutableType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', self::FUNC_ENCRYPT),
            $encryptedType->convertToDatabaseValueSQL('sqlExpr', $platform)
        );
    }

    public function testConvertToPHPValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedDateTimeImmutableType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', self::FUNC_DECRYPT),
            $encryptedType->convertToPHPValueSQL('sqlExpr', $platform)
        );
    }

    public function testGetDefaultFieldLength(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedDateTimeImmutableType();
        self::assertEquals(255, $encryptedType->getDefaultColumnLength($platform));
    }

    public function testGetName(): void
    {
        $encryptedType = new EncryptedDateTimeImmutableType();

        self::assertEquals(TypeEnum::ENCRYPTED_DATETIME_IMMUTABLE, $encryptedType->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedDateTimeImmutableType();
        $sqlDeclaration = $encryptedType->getSQLDeclaration([], $platform);
        self::assertEquals('BINARY_TYPE_DECLARATION', $sqlDeclaration);
    }
}
