<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Validator\Validator;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class ValidationMiddleware implements MiddlewareInterface
{
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $this->validator->assert($envelope->getMessage());

        return $stack->next()->handle($envelope, $stack);
    }
}

