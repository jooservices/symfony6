<?php

namespace App\Core\Client;

use App\Core\Client\Response\CopResponseInterface;

interface ClientInterface
{
    public function get(string $url, array $requestOptions = []): CopResponseInterface;

    public function post(string $url, array $requestOptions = []): CopResponseInterface;

    public function put(string $url, array $requestOptions = []): CopResponseInterface;

    public function delete(string $url, array $requestOptions = []): CopResponseInterface;

    public function patch(string $url, array $requestOptions = []): CopResponseInterface;

    public function request(string $method, string $url, array $requestOptions = []): CopResponseInterface;

    public function withOptions(array $requestOptions): static;
}
