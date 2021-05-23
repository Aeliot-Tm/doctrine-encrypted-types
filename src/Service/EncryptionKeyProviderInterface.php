<?php

namespace Aeliot\Bundle\EncryptDB\Service;

interface EncryptionKeyProviderInterface
{
    public function getSecret(string $connectionName): string;
}
