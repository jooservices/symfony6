<?php

namespace App\Core\Client\Event;

use App\Core\Client\RequestOptions;
use App\Core\Client\Response\CopResponseInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AfterClientRequested extends Event
{
    public const NAME = 'client.after_requested';

    public function __construct(
        private readonly string $method,
        private readonly string $url,
        private readonly ?RequestOptions $requestOptions,
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

    public function getRequestOptions(): array
    {
        return $this->requestOptions ? $this->requestOptions->toArray() : [];
    }

    public function getResponse(): CopResponseInterface
    {
        return $this->response;
    }
}
