<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\DatabaseErrorEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Enum\PlatformEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class AbstractFunctionProvider implements FunctionProviderInterface
{
    public function getList(): array
    {
        return array_keys($this->getDefinitions());
    }

    public function getDefinition(string $functionName, AbstractPlatform $platform): string
    {
        $definitions = $this->getDefinitions();
        $platformName = $platform->getName();

        if (!isset($definitions[$functionName][$platformName])) {
            throw new \LogicException(sprintf('Undefined function %s for platform %s', $functionName, $platformName));
        }

        return $definitions[$functionName][$platformName];
    }

    /**
     * @return array<string,array<string,string>>
     */
    protected function getDefinitions(): array
    {
        return [
            FunctionEnum::FUNCTION_DECRYPT => [
                PlatformEnum::MYSQL => sprintf(
                    'CREATE FUNCTION %1$s(source_data TEXT) RETURNS TEXT DETERMINISTIC
                     BEGIN
                        RETURN AES_DECRYPT(source_data, %2$s());
                     END;',
                    FunctionEnum::FUNCTION_DECRYPT,
                    FunctionEnum::FUNCTION_GET_ENCRYPTION_KEY
                ),
            ],
            FunctionEnum::FUNCTION_ENCRYPT => [
                PlatformEnum::MYSQL => sprintf(
                    'CREATE FUNCTION %1$s(source_data TEXT) RETURNS TEXT DETERMINISTIC
                     BEGIN
                        RETURN AES_ENCRYPT(source_data, %2$s());
                     END;',
                    FunctionEnum::FUNCTION_ENCRYPT,
                    FunctionEnum::FUNCTION_GET_ENCRYPTION_KEY
                ),
            ],
            FunctionEnum::FUNCTION_GET_ENCRYPTION_KEY => [
                PlatformEnum::MYSQL => sprintf(
                    'CREATE FUNCTION %1$s() RETURNS TEXT DETERMINISTIC
                     BEGIN
                        IF (@encryption_key IS NULL OR LENGTH(@encryption_key) = 0) THEN
                            SIGNAL SQLSTATE \'%2$s\'
                                SET MESSAGE_TEXT = \'Encryption key not found\';
                        END IF;
                        RETURN @encryption_key;
                     END;',
                    FunctionEnum::FUNCTION_GET_ENCRYPTION_KEY,
                    DatabaseErrorEnum::EMPTY_ENCRYPTION_KEY
                ),
            ],
        ];
    }
}
