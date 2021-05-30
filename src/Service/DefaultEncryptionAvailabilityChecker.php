<?php

namespace Aeliot\Bundle\EncryptDB\Service;

use Doctrine\ORM\EntityManager;

class DefaultEncryptionAvailabilityChecker implements EncryptionAvailabilityCheckerInterface
{
    public function isEncryptionAvailable(EntityManager $manager, bool $isGoingEncrypt): bool
    {
        return true;
    }
}
