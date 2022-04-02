<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;

class FieldsEncryptCommand extends FieldsTransformCommand
{
    protected static $defaultName = 'doctrine-encrypted-field:fields:encrypt';

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Encrypt fields');
    }

    protected function getFunction(): string
    {
        return FunctionEnum::FUNCTION_ENCRYPT;
    }
}
