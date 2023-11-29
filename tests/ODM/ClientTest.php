<?php

namespace App\Tests\ODM;

use App\Core\Client\ClientInterface;
use App\Core\Client\Response\CopResponseInterface;
use App\ODM\ODMClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\Exception\ClientException;

class ClientTest extends KernelTestCase
{
    private $client;
    private $parameterBag;
    private $odmClient;
    private $response;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(ClientInterface::class);
        $this->parameterBag = $this->createMock(ParameterBagInterface::class);
        $this->response = $this->createMock(CopResponseInterface::class);

        $this->parameterBag->method('get')->willReturn('http://example.com');
        $this->odmClient = new ODMClient($this->client, $this->parameterBag);

        $this->bootKernel();
    }

    public function testClientGetSuccess()
    {
        $this->client->method('request')->willReturn($this->response);

        $result = $this->odmClient->get('/test');

        $this->assertInstanceOf(CopResponseInterface::class, $result);
    }

    public function testClientGetFailed()
    {
        $this->expectException(ClientException::class);

        $client = $this->getContainer()->get(ODMClient::class);
        /**
         * @TODO Use a mock server with fake URL
         */
        $client->get('api/v1/external/account/account010');
    }
}
