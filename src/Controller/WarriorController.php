<?php
declare(strict_types=1);

namespace App\Controller;

use App\Command\CreateWarriorCommand;
use App\Query\GetWarriorQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WarriorController extends BaseController
{
    /**
     * @Route("api/warriors", methods={"POST"})
     * @ParamConverter("command", class="App\Command\CreateWarriorCommand")
     */
    public function create(CreateWarriorCommand $command): JsonResponse
    {
        $this->commandBus->dispatch($command);

        return new JsonResponse(['id' => $command->id], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("api/warriors/{warriorId}", methods={"GET"})
     */
    public function get(string $warriorId): JsonResponse
    {
        return new JsonResponse($this->handleQuery(new GetWarriorQuery($warriorId)));
    }
}
