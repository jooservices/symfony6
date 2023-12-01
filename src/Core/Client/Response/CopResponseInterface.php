<?php

namespace App\Core\Client\Response;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface CopResponseInterface extends ResponseInterface
{
    public function isSuccess(): bool;
}
