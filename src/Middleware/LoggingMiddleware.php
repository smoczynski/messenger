<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class LoggingMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $this->logger->info(
            "Operation with command {command} executed ",
            ['command' => get_class($envelope->getMessage())]
        );

        return $stack->next()->handle($envelope, $stack);
    }
}

