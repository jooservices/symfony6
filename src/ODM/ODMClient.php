<?php

namespace App\ODM;

use App\Core\Client\ClientInterface;
use App\Core\Client\Response\CopResponseInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ODMClient
{
    private string $baseUri;

    public function __construct(private ClientInterface $client, private readonly ParameterBagInterface $parameterBag)
    {
        $this->baseUri = $this->parameterBag->get('odm_base_uri');
        /**
         * @TODO
         * - Provide authentication
         * - Use Factory instead
         */
        $this->client = $this->client->withOptions([
                'base_uri' => $this->baseUri,
                'verify_host' => false,
                'verify_peer' => false,
        ]);
    }

    public function get(string $path, array $requestOptions = []): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function post(string $path, array $requestOptions = []): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function put(string $path, array $requestOptions = []): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function delete(string $path, array $requestOptions = []): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function patch(string $path, array $requestOptions = []): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function request(string $method, string $path, array $options = []): CopResponseInterface
    {
        return $this->client->request($method, $path, $options);
    }
}
