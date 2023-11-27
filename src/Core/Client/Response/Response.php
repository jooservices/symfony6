<?php

namespace App\Core\Client\Response;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Response implements ResponseInterface
{
    public function __construct(private \Symfony\Contracts\HttpClient\ResponseInterface $response)
    {
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function getHeaders(bool $throw = true): array
    {
        return $this->response->getHeaders($throw);
    }

    public function getContent(bool $throw = true): string
    {
        return $this->response->getContent($throw);
    }

    public function toArray(bool $throw = true): array
    {
        return $this->response->toArray($throw);
    }

    public function cancel(): void
    {
        $this->response->cancel();
    }

    public function getInfo(string $type = null): mixed
    {
        return $this->response->getInfo($type);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function isSuccess(): bool
    {
        return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
    }
}
