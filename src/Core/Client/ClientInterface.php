<?php

namespace App\Core\Client;

use App\Core\Client\Response\CopResponseInterface;

interface ClientInterface
{
    public function get(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface;

    public function post(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface;

    public function put(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface;

    public function delete(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface;

    public function patch(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface;

    public function request(string $method, string $url, ?RequestOptions $requestOptions = null): CopResponseInterface;

    public function withOptions(RequestOptions $requestOptions): static;
}
