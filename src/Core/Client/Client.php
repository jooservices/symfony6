<?php

namespace App\Core\Client;

use App\Core\Client\Response\ResponseInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

/**
 * @Description: This class is a wrapper for the Symfony HttpClientInterface
 */
class Client implements ClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @TODO Validate options
     * @param array $options
     * @return $this
     */
    public function withOptions(array $options): static
    {
        $this->eventDispatcher->dispatch(
            new Event\BeforeUpdateClientOptions($options),
            Event\BeforeUpdateClientOptions::NAME
        );
        $this->client = $this->client->withOptions($options);
        $this->eventDispatcher->dispatch(
            new Event\AfterUpdatedClientOptions($options),
            Event\AfterUpdatedClientOptions::NAME
        );

        return $this;
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $this->eventDispatcher->dispatch(
            new Event\BeforeClientRequest($method, $url, $options),
            Event\BeforeClientRequest::NAME
        );

        $response = $this->client->request(strtoupper($method), $url, $options);
        $response = new Response\Response($response);

        $this->eventDispatcher->dispatch(
            new Event\AfterClientRequested($method, $url, $options, $response),
            Event\AfterClientRequested::NAME
        );

        return $response;
    }

    public function stream(
        iterable|ResponseInterface|\Symfony\Contracts\HttpClient\ResponseInterface $responses,
        float $timeout = null
    ): ResponseStreamInterface {
        return $this->client->stream($responses, $timeout);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function get(string $url, array $options = []): ResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $options);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function post(string $url, array $options = []): ResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $options);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function put(string $url, array $options = []): ResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $options);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $options);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function patch(string $url, array $options = []): ResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $options);
    }
}
