<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;

class FieldsDecryptCommand extends FieldsTransformCommand
{
    protected static $defaultName = 'aeliot-encrypt-db:fields:decrypt';

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Decrypt fields');
    }

    protected function getFunction(): string
    {
        return FunctionEnum::FUNCTION_DECRYPT;
    }
}
