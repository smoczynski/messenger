<?php
declare(strict_types=1);

namespace App\Normalizer;

use App\Entity\Warrior;

class WarriorNormalizer
{
    public function normalize(Warrior $warrior): array
    {
        return [
            'id' => $warrior->getId()->toString(),
            'name' => $warrior->getName(),
            'battleTactics' => $warrior->getBattleTactics(),
            'region' => $warrior->getRegion(),
            'armament' => $warrior->getArmament(),
            'createdAt' => $warrior->getCreatedAt()->format('Y-m-d'),
        ];
    }
}
