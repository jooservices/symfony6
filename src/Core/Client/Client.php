<?php

namespace App\Core\Client;

use App\Core\Client\Response\CopResponseInterface;
use App\Core\Exceptions\GeneralException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
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
        private HttpClientInterface               $client,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @TODO Validate options
     * @param RequestOptions $requestOptions
     * @return $this
     */
    public function withOptions(RequestOptions $requestOptions): static
    {
        $this->eventDispatcher->dispatch(
            new Event\BeforeUpdateClientOptions($requestOptions),
            Event\BeforeUpdateClientOptions::NAME
        );

        $this->client = $this->client->withOptions($requestOptions->toArray());

        $this->eventDispatcher->dispatch(
            new Event\AfterUpdatedClientOptions($requestOptions),
            Event\AfterUpdatedClientOptions::NAME
        );

        return $this;
    }

    /**
     * @throws GeneralException|TransportExceptionInterface
     */
    public function request(string $method, string $url, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        /**
         * @link https://symfony.com/doc/current/http_client.html
         * @link https://github.com/symfony/symfony/blob/6.3/src/Symfony/Contracts/HttpClient/HttpClientInterface.php
         */
        try {
            $this->eventDispatcher->dispatch(
                new Event\BeforeClientRequest($method, $url, $requestOptions),
                Event\BeforeClientRequest::NAME
            );

            $response = $this->client->request(
                strtoupper($method),
                $url,
                $requestOptions ? $requestOptions->toArray() : []
            );

            $copResponse = new Response\CopResponse($response);

            $this->eventDispatcher->dispatch(
                new Event\AfterClientRequested($method, $url, $requestOptions, $copResponse),
                Event\AfterClientRequested::NAME
            );
        } catch (\Exception $e) {
            if ($e instanceof HttpExceptionInterface) {
                return new Response\CopResponse($e->getResponse());
            }

            throw new GeneralException($e->getMessage(), $e->getCode(), $e);
        }

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
     * @throws GeneralException
     */
    public function get(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws GeneralException
     */
    public function post(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws GeneralException
     */
    public function put(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws GeneralException
     */
    public function delete(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws GeneralException
     */
    public function patch(string $url, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->request(__FUNCTION__, $url, $requestOptions);
    }
}
