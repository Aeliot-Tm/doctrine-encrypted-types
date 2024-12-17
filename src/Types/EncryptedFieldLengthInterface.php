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

use Doctrine\DBAL\Platforms\AbstractPlatform;

interface EncryptedFieldLengthInterface
{
    public function getDefaultFieldLength(AbstractPlatform $platform): ?int;
}