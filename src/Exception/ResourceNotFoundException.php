<?php
declare(strict_types=1);

namespace App\Exception;

use HttpException;
use Symfony\Component\HttpFoundation\Response;

class ResourceNotFoundException extends HttpException
{
    public function __construct(string $message = "Resource not found.")
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
