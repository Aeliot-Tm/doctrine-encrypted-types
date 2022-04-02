<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\AELIOT;

use Doctrine\DBAL\Platforms\AbstractPlatform;

interface EncryptedFieldLengthInterface
{
    public function getDefaultFieldLength(AbstractPlatform $platform): ?int;
}
