<?php

namespace Aeliot\Bundle\EncryptDB\Service;

use Doctrine\ORM\EntityManager;

interface EncryptionAvailabilityCheckerInterface
{
    public function isEncryptionAvailable(EntityManager $manager, bool $isGoingEncrypt): bool;
}
