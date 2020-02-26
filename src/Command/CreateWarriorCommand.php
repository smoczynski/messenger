<?php
declare(strict_types=1);

namespace App\Command;

use App\Contract\JsonInputInterface;
use Exception;
use Ramsey\Uuid\Uuid;

class CreateWarriorCommand implements JsonInputInterface
{
    public $id;
    public $name;
    public $region;
    public $battleTactics;
    public $armament;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }
}



