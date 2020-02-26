<?php
declare(strict_types=1);

namespace App\QueryHandler;

use App\Entity\Warrior;
use App\Exception\ResourceNotFoundException;
use App\Normalizer\WarriorNormalizer;
use App\Query\GetWarriorQuery;
use App\Repository\WarriorRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetWarriorHandler implements MessageHandlerInterface
{
    private WarriorRepository $warriorRepository;
    private WarriorNormalizer $warriorNormalizer;

    public function __construct(
        WarriorRepository $warriorRepository,
        WarriorNormalizer $warriorNormalizer
    ) {
        $this->warriorRepository = $warriorRepository;
        $this->warriorNormalizer = $warriorNormalizer;
    }

    public function __invoke(GetWarriorQuery $query): array
    {
        $warriorId = Uuid::fromString($query->id);

        /** @var Warrior $warrior */
        $warrior = $this->warriorRepository->find($warriorId);

        if (null === $warrior) {
            throw new ResourceNotFoundException();
        }

        return $this->warriorNormalizer->normalize($warrior);
    }
}
