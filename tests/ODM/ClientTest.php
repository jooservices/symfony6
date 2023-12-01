<?php

namespace App\Tests\ODM;

use App\Core\Client\ClientInterface;
use App\Core\Client\Response\CopResponseInterface;
use App\ODM\ODMClient;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ClientTest extends KernelTestCase
{
    private MockObject $client;
    private ParameterBagInterface $parameterBag;
    private ODMClient $odmClient;
    private CopResponseInterface $response;

    /**
     * @throws Exception
     */
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
        $client = $this->getContainer()->get(ODMClient::class);
        /**
         * @TODO Use a mock server with fake URL
         */
        $response = $client->get('api/v1/external/account/account010');
        $this->assertFalse($response->isSuccess());
    }
}
