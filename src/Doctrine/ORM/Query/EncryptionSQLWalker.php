<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Doctrine\ORM\Query;

use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Types\EncryptionUtilsTrait;
use Aeliot\Bundle\DoctrineEncryptedField\Enum\EncryptedTypeEnum;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\SqlWalker;

class EncryptionSQLWalker extends SqlWalker
{
    use EncryptionUtilsTrait;

    /**
     * @param PathExpression $pathExpr
     */
    public function walkPathExpression($pathExpr): string
    {
        $sql = parent::walkPathExpression($pathExpr);

        if ($pathExpr->type === PathExpression::TYPE_STATE_FIELD && $pathExpr->field) {
            $this->getDecryptedPathExpression($pathExpr->identificationVariable, $pathExpr->field, $sql);
        }

        return $sql;
    }

    private function getDecryptedPathExpression(string $dqlAlias, string $fieldName, string &$sql)
    {
        if ($fieldName && array_key_exists($dqlAlias, $this->getQueryComponents())) {
            /** @var ClassMetadata $metadata */
            $metadata = $this->getQueryComponent($dqlAlias)['metadata'];
            $fieldMapping = $metadata->getFieldMapping($fieldName);

            if (in_array($fieldMapping['type'], EncryptedTypeEnum::getAll(), true)) {
                $platform = $this->getConnection()->getDatabasePlatform();
                $sql = $this->getDecryptSQLExpression($sql, $platform);
            }
        }
    }
}
