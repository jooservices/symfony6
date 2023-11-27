<?php

namespace App\Core\Client\Event;

use Symfony\Contracts\EventDispatcher\Event;

class BeforeClientRequest extends Event
{
    const NAME = 'client.before_request';

    public function __construct(private string $method, private string $url, private array $options = [])
    {
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
