<?php

namespace App\ODM\Adapter;

use App\Core\Client\RequestOptions;
use App\ODM\ODMAdapterInterface;
use App\ODM\ODMClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ContractApiAdapter implements ODMAdapterInterface
{
    public function __construct(private readonly ODMClient $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function list(array $options): array
    {
        return $this->client->get('api/v1/external/contract/', new RequestOptions(['query' => $options]))->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function item(string $id): array
    {
        return $this->client->get('api/v1/external/contract/' . $id)->toArray();
    }

    public function update(string $id, array $data): array
    {
        return [];
    }

    public function create(array $data): array
    {
        return [];
    }

    public function delete(string $id): bool
    {
        return true;
    }
}
