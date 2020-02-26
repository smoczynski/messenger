<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

abstract class BaseController
{
    use HandleTrait;

    protected MessageBusInterface $commandBus;
    protected MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $commandBus, MessageBusInterface $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * used HandleTrait logic but with specified Message Bus -> Query Bus
     * @param $message
     * @return mixed
     */
    protected function handleQuery($message)
    {
        if (!$this->queryBus instanceof MessageBusInterface) {
            throw new LogicException(
                sprintf(
                    'You must provide a "%s" instance in the "%s::$messageBus" property, "%s" given.',
                    MessageBusInterface::class,
                    get_class($this),
                    is_object($this->queryBus) ? get_class($this->queryBus) : gettype($this->queryBus)
                )
            );
        }

        $envelope = $this->queryBus->dispatch($message);

        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);

        if (!$handledStamps) {
            throw new LogicException(
                sprintf(
                    'Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".',
                    get_class($envelope->getMessage()),
                    get_class($this),
                    __FUNCTION__
                )
            );
        }

        if (count($handledStamps) > 1) {
            $handlers = implode(', ', array_map(function (HandledStamp $stamp): string {
                return sprintf('"%s"', $stamp->getHandlerName());
            }, $handledStamps));

            throw new LogicException(
                sprintf(
                    'Message of type "%s" was handled multiple times. Only one handler is expected when using "%s::%s()", got %d: %s.',
                    get_class($envelope->getMessage()),
                    get_class($this), __FUNCTION__,
                    count($handledStamps),
                    $handlers
                )
            );
        }

        return $handledStamps[0]->getResult();
    }
}
