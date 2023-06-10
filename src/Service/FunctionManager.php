<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

use Doctrine\DBAL\Connection;

final class FunctionManager
{
    public function __construct(private FunctionProviderInterface $functionProvider)
    {
    }

    public function addFunction(Connection $connection, string $functionName): void
    {
        $connection->prepare($this->getFunctionDefinition($connection, $functionName))->execute();
    }

    /**
     * @return string[]
     */
    public function getList(): array
    {
        return $this->functionProvider->getList();
    }

    public function hasFunction(Connection $connection, string $functionName): bool
    {
        $sql = 'SELECT COUNT(1) AS functions_count
                  FROM information_schema.ROUTINES
                 WHERE ROUTINE_SCHEMA = :routine_schema
                   AND ROUTINE_TYPE = :routine_type
                   AND ROUTINE_NAME = :routine_name';

        return (bool) $connection->prepare($sql)
            ->executeQuery([
                'routine_schema' => $connection->getDatabase(),
                'routine_type' => 'FUNCTION',
                'routine_name' => $functionName,
            ])
            ->fetchAssociative()['functions_count'];
    }

    public function removeFunction(Connection $connection, string $functionName): void
    {
        $connection->prepare(sprintf('DROP FUNCTION %s;', $functionName))->execute();
    }

    private function getFunctionDefinition(Connection $connection, string $functionName): string
    {
        return $this->functionProvider->getDefinition($functionName, $connection->getDatabasePlatform());
    }
}
