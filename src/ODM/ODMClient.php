<?php

namespace App\ODM;

use App\Core\Client\ClientInterface;
use App\Core\Client\RequestOptions;
use App\Core\Client\Response\CopResponseInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ODMClient
{
    public function __construct(private ClientInterface $client, private readonly ParameterBagInterface $parameterBag)
    {
        /**
         * @TODO
         * - Provide authentication
         * - Use Factory instead
         */
        $requestOptions = new RequestOptions([
                'base_uri' => $this->parameterBag->get('odm_base_uri'),
                'verify_host' => false,
                'verify_peer' => false,
        ]);
        $this->client = $this->client->withOptions($requestOptions);
    }

    public function get(string $path, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function post(string $path, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function put(string $path, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function delete(string $path, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function patch(string $path, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->client->request(__FUNCTION__, $path, $requestOptions);
    }

    public function request(string $method, string $path, ?RequestOptions $requestOptions = null): CopResponseInterface
    {
        return $this->client->request($method, $path, $requestOptions);
    }
}
