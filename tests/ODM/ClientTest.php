<?php

namespace App\Tests\ODM;

use App\ODM\ODMClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\Exception\ClientException;

class ClientTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->bootKernel();
    }

    public function testClientGetSuccess()
    {
        $client = $this->getContainer()->get(ODMClient::class);
        /**
         * @TODO Use a mock server with fake URL
         */
        $response = $client->get('api/v1/external/account/account01');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->isSuccess());
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
