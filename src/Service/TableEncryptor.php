<?php

namespace Aeliot\Bundle\EncryptDB\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class TableEncryptor
{
    /**
     * @param string[] $columns
     */
    public function convert(
        Connection $connection,
        string $tableName,
        array $columns,
        string $function,
        OutputInterface $output = null
    ) {
        $sql = $this->createSQL($tableName, $columns, $function);
        $this->executeOrShow($connection, $sql, $output);
    }

    /**
     * @param string[] $columns
     */
    private function createSQL(string $tableName, array $columns, string $function): string
    {
        $pieces = array_map(function (string $column) use ($function) {
            return sprintf('%1$s = %2$s(%1$s)', $column, $function);
        }, $columns);

        return sprintf('UPDATE %s SET %s WHERE 1;', $tableName, implode(', ', $pieces));
    }

    private function executeOrShow(Connection $connection, string $sql, OutputInterface $output = null)
    {
        if ($output && !$output instanceof NullOutput) {
            $output->writeln($sql);
        } else {
            $connection->prepare($sql)->executeStatement();
        }
    }
}
