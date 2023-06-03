<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\EventListener;

use Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Logging\MaskingParamsSQLLogger;
use Aeliot\Bundle\DoctrineEncryptedField\Exception\SecurityConfigurationException;
use Aeliot\Bundle\DoctrineEncryptedField\Service\EncryptionKeyProviderInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\ConnectionRegistry;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Events;
use Doctrine\DBAL\Exception as DBALException;

final class EncryptionKeyInjectorSubscriber implements EventSubscriber
{
    /**
     * @param string[] $encryptedConnections
     */
    public function __construct(
        private array $encryptedConnections,
        private ConnectionRegistry $registry,
        private EncryptionKeyProviderInterface $secretProvider,
    ) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postConnect,
        ];
    }

    public function postConnect(ConnectionEventArgs $event): void
    {
        $currentConnection = $event->getConnection();
        $connectionName = $this->getConnectionName($currentConnection);
        if (\in_array($connectionName, $this->encryptedConnections, true)) {
            $key = $this->secretProvider->getSecret($connectionName);
            if (!$key) {
                throw new SecurityConfigurationException('Project encryption key is undefined.');
            }
            $this->secretProvider->prepareConnection($currentConnection);
            $param = $this->secretProvider->wrapParameter(':encryption_key');
            $statement = $currentConnection->prepare(sprintf('SET @encryption_key = %s;', $param));
            if ($logger = $currentConnection->getConfiguration()->getSQLLogger()) {
                $currentConnection->getConfiguration()->setSQLLogger(
                    new MaskingParamsSQLLogger(
                        $logger,
                        ['encryption_key']
                    )
                );
            }
            try {
                $statement->execute(['encryption_key' => $key]);
            } catch (DBALException $exception) {
                throw new \RuntimeException('Failed to inject encryption key.', 0, $exception);
            }
        }
    }

    private function getConnectionName(Connection $currentConnection): ?string
    {
        foreach ($this->registry->getConnections() as $name => $connection) {
            if ($connection === $currentConnection) {
                return $name;
            }
        }

        return null;
    }
}
