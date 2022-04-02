<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

use Doctrine\DBAL\Connection;

class FunctionManager
{
    private FunctionProviderInterface $functionProvider;

    public function __construct(FunctionProviderInterface $functionProvider)
    {
        $this->functionProvider = $functionProvider;
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
        $statement = $connection->prepare('SHOW FUNCTION STATUS;');
        $statement->execute();
        $databaseName = $connection->getDatabase();
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $item) {
            $item = array_combine(array_map('\strtolower', array_keys($item)), array_values($item));
            if (($item['name'] === $functionName) && ($item['db'] === $databaseName)) {
                return true;
            }
        }

        return false;
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
