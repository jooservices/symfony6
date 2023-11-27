<?php

namespace App\Core\Client\Response;

interface ResponseInterface extends \Symfony\Contracts\HttpClient\ResponseInterface
{
    public function isSuccess(): bool;
}
