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

namespace Aeliot\DoctrineEncrypted\Types\Tests\Unit\Types;

use Aeliot\DoctrineEncrypted\Types\Enum\TypeEnum;
use Aeliot\DoctrineEncrypted\Types\Types\EncryptedDateImmutableType;

final class EncryptedDateImmutableTypeTest extends AbstractTypeTestCase
{
    public function testCanRequireSQLConversion(): void
    {
        $encryptedType = new EncryptedDateImmutableType();
        self::assertTrue($encryptedType->canRequireSQLConversion());
    }

    public function testConvertToDatabaseValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedDateImmutableType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', self::FUNC_ENCRYPT),
            $encryptedType->convertToDatabaseValueSQL('sqlExpr', $platform)
        );
    }

    public function testConvertToPHPValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedDateImmutableType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', self::FUNC_DECRYPT),
            $encryptedType->convertToPHPValueSQL('sqlExpr', $platform)
        );
    }

    public function testGetDefaultFieldLength(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedDateImmutableType();
        self::assertEquals(255, $encryptedType->getDefaultColumnLength($platform));
    }

    public function testGetName(): void
    {
        $encryptedType = new EncryptedDateImmutableType();

        self::assertEquals(TypeEnum::ENCRYPTED_DATE_IMMUTABLE, $encryptedType->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedDateImmutableType();
        $sqlDeclaration = $encryptedType->getSQLDeclaration([], $platform);
        self::assertEquals('BINARY_TYPE_DECLARATION', $sqlDeclaration);
    }
}
