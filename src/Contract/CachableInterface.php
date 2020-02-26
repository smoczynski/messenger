<?php
declare(strict_types=1);

namespace App\Contract;

interface CachableInterface
{
    public function key(): string;

    public function tags(): array;
}
