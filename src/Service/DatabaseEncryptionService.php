<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\EncryptedTypeEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Exception\EncryptionAvailabilityException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Symfony\Component\Console\Output\OutputInterface;

final class DatabaseEncryptionService
{
    public function __construct(
        private EncryptionAvailabilityCheckerInterface $databaseEncryptionChecker,
        private ManagerRegistry $registry,
        private TableEncryptor $tableEncryptor
    ) {
    }

    public function decrypt(string $managerName, OutputInterface $output = null): void
    {
        $this->convertDatabases($managerName, FunctionEnum::FUNCTION_DECRYPT, $output);
    }

    public function encrypt(string $managerName, OutputInterface $output = null): void
    {
        $this->convertDatabases($managerName, FunctionEnum::FUNCTION_ENCRYPT, $output);
    }

    private function convertDatabases(string $managerName, string $function, OutputInterface $output = null): void
    {
        /** @var EntityManager $manager */
        $manager = $this->registry->getManager($managerName);

        $isEncryptionAvailable = $this->databaseEncryptionChecker
            ->isEncryptionAvailable($manager, FunctionEnum::FUNCTION_ENCRYPT === $function);
        if (!$isEncryptionAvailable) {
            throw new EncryptionAvailabilityException(
                sprintf('Connection "%s" can not be converted.', $managerName)
            );
        }

        try {
            $manager->beginTransaction();

            /** @var ClassMetadataInfo<object> $metadata */
            foreach ($manager->getMetadataFactory()->getAllMetadata() as $metadata) {
                $fields = $this->getFields($metadata);
                $tableName = $metadata->getTableName();
                if ($output) {
                    $output->writeln(json_encode([$tableName => $fields]));
                }
                if (!$fields) {
                    continue;
                }

                $columns = $this->getColumns($metadata, $fields);
                $this->tableEncryptor->convert($manager->getConnection(), $tableName, $columns, $function, $output);
            }

            $manager->commit();
        } catch (\Throwable $exception) {
            $manager->rollback();

            throw $exception;
        }
    }

    /**
     * @param string[] $fields
     *
     * @return string[]
     */
    private function getColumns(ClassMetadataInfo $metadata, array $fields): array
    {
        return array_map(function (string $fieldName) use ($metadata) {
            return $metadata->getColumnName($fieldName);
        }, $fields);
    }

    /**
     * @return string[]
     */
    private function getFields(ClassMetadata $metadata): array
    {
        $fieldsToEncrypt = [];

        foreach ($metadata->getFieldNames() as $fieldName) {
            $fieldType = $metadata->getTypeOfField($fieldName);
            if (\in_array($fieldType, EncryptedTypeEnum::all(), true)) {
                $fieldsToEncrypt[] = $fieldName;
            }
        }

        return $fieldsToEncrypt;
    }
}
