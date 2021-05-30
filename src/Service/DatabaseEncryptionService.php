<?php

namespace Aeliot\Bundle\EncryptDB\Service;

use Aeliot\Bundle\EncryptDB\Enum\EncryptedTypeEnum;
use Aeliot\Bundle\EncryptDB\Enum\FunctionEnum;
use Aeliot\Bundle\EncryptDB\Exception\EncryptionAvailabilityException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseEncryptionService
{
    private $databaseEncryptionChecker;
    private $registry;
    private $tableEncryptor;

    public function __construct(
        EncryptionAvailabilityCheckerInterface $databaseEncryptionChecker,
        ManagerRegistry $registry,
        TableEncryptor $tableEncryptor
    ) {
        $this->tableEncryptor = $tableEncryptor;
        $this->registry = $registry;
        $this->databaseEncryptionChecker = $databaseEncryptionChecker;
    }

    public function decrypt(string $managerName, OutputInterface $output = null)
    {
        $this->convertDatabases($managerName, FunctionEnum::FUNCTION_DECRYPT, $output);
    }

    public function encrypt(string $managerName, OutputInterface $output = null)
    {
        $this->convertDatabases($managerName, FunctionEnum::FUNCTION_ENCRYPT, $output);
    }

    private function convertDatabases(string $managerName, string $function, OutputInterface $output = null)
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
            if (\in_array($fieldType, EncryptedTypeEnum::getAll(), true)) {
                $fieldsToEncrypt[] = $fieldName;
            }
        }

        return $fieldsToEncrypt;
    }
}
