<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Ramsey\Uuid\UuidInterface;

class Warrior
{
    private UuidInterface $id;
    private string $name;
    private string $region;
    private string $battleTactics;
    private string $armament;
    private DateTime $createdAt;

    public function __construct(
        UuidInterface $id,
        string $name,
        string $region,
        string $battleTactics,
        string $armament
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->region = $region;
        $this->battleTactics = $battleTactics;
        $this->armament = $armament;
        $this->createdAt = new DateTime();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getBattleTactics(): string
    {
        return $this->battleTactics;
    }

    public function getArmament(): string
    {
        return $this->armament;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
