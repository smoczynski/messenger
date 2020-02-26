<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Warrior;
use Doctrine\Persistence\ManagerRegistry;

class WarriorRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Warrior::class);
    }
}
