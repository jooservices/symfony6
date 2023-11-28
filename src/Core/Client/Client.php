<?php

namespace App\Core\Client;

use App\Core\Client\Response\CopResponse;
use App\Core\Client\Response\CopResponseInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
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
     * @param array $requestOptions
     * @return $this
     */
    public function withOptions(array $requestOptions): static
    {
        $this->eventDispatcher->dispatch(
            new Event\BeforeUpdateClientOptions($requestOptions),
            Event\BeforeUpdateClientOptions::NAME
        );
        $this->client = $this->client->withOptions($requestOptions);
        $this->eventDispatcher->dispatch(
            new Event\AfterUpdatedClientOptions($requestOptions),
            Event\AfterUpdatedClientOptions::NAME
        );

        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function request(string $method, string $url, array $requestOptions = []): CopResponseInterface
    {
        $this->eventDispatcher->dispatch(
            new Event\BeforeClientRequest($method, $url, $requestOptions),
            Event\BeforeClientRequest::NAME
        );

        /**
         * @TODO Validate options
         */
        $response = $this->client->request(strtoupper($method), $url, $requestOptions);
        $copResponse = new Response\CopResponse($response);

        $this->eventDispatcher->dispatch(
            new Event\AfterClientRequested($method, $url, $requestOptions, $copResponse),
            Event\AfterClientRequested::NAME
        );

        return $copResponse;
    }

    public function stream(
        iterable|CopResponseInterface|ResponseInterface $responses,
        float                                           $timeout = null
    ): ResponseStreamInterface {
        return $this->client->stream($responses, $timeout);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function get(string $url, array $requestOptions = []): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function post(string $url, array $requestOptions = []): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function put(string $url, array $requestOptions = []): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function delete(string $url, array $requestOptions = []): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function patch(string $url, array $requestOptions = []): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }
}
