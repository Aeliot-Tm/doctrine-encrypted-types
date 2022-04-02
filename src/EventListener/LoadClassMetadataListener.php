<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\EventListener;

use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\EncryptedFieldLengthInterface;
use Aeliot\Bundle\DoctrineEncryptedField\Enum\EncryptedTypeEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Exception\ConfigurationException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class LoadClassMetadataListener
{
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $encryptedTypes = EncryptedTypeEnum::getAll();
        /** @var AbstractPlatform $platform */
        $platform = $eventArgs->getEntityManager()->getConnection()->getDatabasePlatform();

        foreach ($classMetadata->fieldMappings as &$fieldMapping) {
            $fieldType = $fieldMapping['type'];
            if (!\in_array($fieldType, $encryptedTypes, true)) {
                continue;
            }

            $length = $fieldMapping['length']
                ?? $this->getFieldTypeDefinition($fieldType)->getDefaultFieldLength($platform);

            /* @link https://dev.mysql.com/doc/refman/5.7/en/encryption-functions.html#function_aes-encrypt */
            $fieldMapping['length'] = null === $length ? null : 16 * (floor($length * 4 / 16) + 1);
        }
    }

    private function getFieldTypeDefinition(string $fieldType): EncryptedFieldLengthInterface
    {
        $fieldTypeDefinition = Type::getType($fieldType);
        if (!$fieldTypeDefinition instanceof EncryptedFieldLengthInterface) {
            throw new ConfigurationException(
                sprintf('Type "%s" should implement interface "%s".', $fieldType, EncryptedFieldLengthInterface::class)
            );
        }

        return $fieldTypeDefinition;
    }
}
