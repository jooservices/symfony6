<?php

namespace App\Core\Client;

use App\Core\Client\Response\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

interface ClientInterface extends HttpClientInterface
{
    public function get(string $url, array $options = []): ResponseInterface;

    public function post(string $url, array $options = []): ResponseInterface;

    public function put(string $url, array $options = []): ResponseInterface;

    public function delete(string $url, array $options = []): ResponseInterface;

    public function patch(string $url, array $options = []): ResponseInterface;
}
