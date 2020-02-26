<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    public function persist($entity): void
    {
        $this->_em->persist($entity);
    }

    public function remove($entity): void
    {
        $this->_em->remove($entity);
    }
}
