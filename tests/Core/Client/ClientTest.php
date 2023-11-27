<?php

namespace App\Tests\Core\Client;

use App\Core\Client\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * @covers \App\Core\Client\Client
 * @TODO Mocking Symfony ClientInterface
 */
class ClientTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testClientWithException()
    {
        $this->expectException(TransportExceptionInterface::class);
        $client = $this->getContainer()->get(Client::class);
        $client->request('GET', 'https://invalid.domain/');
    }

    public function testClientWithSuccess()
    {
        $client = $this->getContainer()->get(Client::class);
        $response = $client->request('GET', 'https://example.com/');
        $this->assertTrue($response->isSuccess());
    }
}
