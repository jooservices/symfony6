<?php

namespace App\Core\Client\Event;

use App\Core\Client\Response\CopResponseInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AfterClientRequested extends Event
{
    public const NAME = 'client.after_requested';

    public function __construct(
        private readonly string $method,
        private readonly string $url,
        private readonly array $options,
        private readonly CopResponseInterface $response
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

    public function getResponse(): CopResponseInterface
    {
        return $this->response;
    }
}
