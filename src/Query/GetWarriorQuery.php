<?php
declare(strict_types=1);

namespace App\Query;

use App\Contract\CachableInterface;

class GetWarriorQuery implements CachableInterface
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function key(): string
    {
        return md5(
            serialize(
                [
                    'command' => __CLASS__,
                    'warrior' => $this->id,
                ]
            )
        );
    }

    public function tags(): array
    {
        return ['warrior', "warrior-{$this->id}"];
    }
}
