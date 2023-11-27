<?php

namespace App\Core\Client\Event;

use Symfony\Contracts\EventDispatcher\Event;

class BeforeClientRequest extends Event
{
    public const NAME = 'client.before_client_request';

    public function __construct(
        private readonly string $method,
        private readonly string $url,
        private readonly array $options = []
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

    public function getOptions(): array
    {
        return $this->options;
    }
}
