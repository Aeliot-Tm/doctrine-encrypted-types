<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;

class FieldsEncryptCommand extends FieldsTransformCommand
{
    protected static $defaultName = 'doctrine-encrypted-field:fields:encrypt';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Encrypt fields');
    }

    protected function getFunction(): string
    {
        return FunctionEnum::FUNCTION_ENCRYPT;
    }
}
