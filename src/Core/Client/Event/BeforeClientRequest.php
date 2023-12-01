<?php

namespace App\Core\Client\Event;

use App\Core\Client\RequestOptions;
use Symfony\Contracts\EventDispatcher\Event;

class BeforeClientRequest extends Event
{
    public const NAME = 'client.before_client_request';

    public function __construct(
        private readonly string $method,
        private readonly string $url,
        private readonly ?RequestOptions $requestOptions
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getRequestOptions(): array
    {
        return $this->requestOptions ? $this->requestOptions->toArray() : [];
    }
}
