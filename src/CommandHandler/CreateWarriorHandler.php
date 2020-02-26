<?php
declare(strict_types=1);

namespace App\CommandHandler;

use App\Command\CreateWarriorCommand;
use App\Entity\Warrior;
use App\Repository\WarriorRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateWarriorHandler implements MessageHandlerInterface
{
    private WarriorRepository $warriorRepository;

    public function __construct(WarriorRepository $warriorRepository)
    {
        $this->warriorRepository = $warriorRepository;
    }

    public function __invoke(CreateWarriorCommand $command): void
    {
        $warrior = new Warrior(
            Uuid::fromString($command->id),
            $command->name,
            $command->region,
            $command->battleTactics,
            $command->armament
        );

        $this->warriorRepository->persist($warrior);
    }
}
