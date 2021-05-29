<?php

namespace Aeliot\Bundle\EncryptDB\Doctrine\DBAL\Types\AELIOT;

use Aeliot\Bundle\EncryptDB\Enum\EncryptedTypeEnum;
use Doctrine\DBAL\Types\StringType;

class EncryptedStringType extends StringType
{
    use EncryptionTrait;

    public function getName(): string
    {
        return EncryptedTypeEnum::AELIOT_ENCRYPTED_STRING;
    }
}
