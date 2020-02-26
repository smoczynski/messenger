<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Contract\CachableInterface;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CachingMiddleware implements MiddlewareInterface
{
    private TagAwareAdapterInterface $cache;

    public function __construct(TagAwareAdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (!$envelope->getMessage() instanceof CachableInterface) {
            return $stack->next()->handle($envelope, $stack);
        }

        return $this->cache->get(
            $envelope->getMessage()->key(),
            function (ItemInterface $item) use ($envelope, $stack) {
                $item->tag($envelope->getMessage()->tags());

                return $stack->next()->handle($envelope, $stack);
            }
        );
    }
}
