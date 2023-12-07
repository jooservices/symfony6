<?php

namespace App\Tests\Controllers;

use App\ApiModel\Resource\Address\AddressDto;
use App\ApiModel\Resource\Address\AddressList;
use App\ApiModel\Resource\Contract\ContractDto;
use App\ApiModel\Resource\PagingMeta;
use App\Tests\AssertHelper;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AccountAddressControllerTest extends WebTestCase
{
    use AssertHelper;

    private KernelBrowser $client;

    private const DUMMY_ADDRESS_UID = 'a93ff1ff-09ff-480c-9bc4-2a8da9bd2ksa';
    private const DUMMY_ACCOUNT_UID = 'a93ff1ff-09ff-480c-9bc4-2a8da9bd2312';
    private const DUMMY_RESPONSE = [
        'externalAddressId' => self::DUMMY_ADDRESS_UID,
        'externalAccountId' => self::DUMMY_ACCOUNT_UID,
        'addressType' => 'test',
        'street' => 'johnhoe',
        'streetNum' => '123123',
        'city' => 'ca mau',
        'region' => 'VB',
        'country' => 'vn',
        'zip' => '600000',
        'addressStatus' => 'status',
        'relType' => 'test',
        'sourceSystemCode' => 'test',
    ];
    private const DUMMY_PAYLOAD = [
        'addressType' => 'test',
        'street' => 'johnhoe',
        'streetNum' => '123123',
        'city' => 'ca mau',
        'region' => 'VB',
        'country' => 'vn',
        'zip' => '600000',
        'addressStatus' => 'status',
        'relType' => 'test',
        'sourceSystemCode' => 'test',
    ];

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testRetrieveAddressesByAccount()
    {
        $faker = new AddressList();
        $faker->data = array_map(fn ($item) => (new AddressDto())->loadFromArray($item), [self::DUMMY_RESPONSE]);

        $meta = new PagingMeta();
        $meta->totalPages = 1;
        $meta->totalRecords = $faker->data ? count($faker->data) : 0;
        $meta->currentPage = 1;
        $meta->pageSize = 1;
        $faker->meta = $meta;

        $mockResponse = new Response(json_encode($faker), 200);
        $httpClientMock = $this->getMockBuilder(KernelBrowser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $httpClientMock->method('getResponse')->willReturn($mockResponse);

        $this->client = $httpClientMock;
        $this->client->request('GET', '/api/accounts/' . self::DUMMY_ACCOUNT_UID . '/addresses');
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsObject($response);
        $this->assertEquals(self::DUMMY_ACCOUNT_UID, $response->data[0]->accountUid);
        $this->assertEquals(1, count($response->data));

        $expectedProperties = [
            'data',
            'meta',
        ];

        $this->assertObjectHasProperties($response, $expectedProperties);
    }

    public function testCreateAddress()
    {
        $faker = (new AddressDto())->loadFromArray(self::DUMMY_RESPONSE);

        $mockResponse = new Response(json_encode($faker), 200);
        $httpClientMock = $this->getMockBuilder(KernelBrowser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $httpClientMock->method('getResponse')->willReturn($mockResponse);

        $this->client = $httpClientMock;
        $this->client->request(
            'POST',
            '/api/accounts/' . self::DUMMY_ACCOUNT_UID . '/addresses',
            [
                'json' => self::DUMMY_PAYLOAD
            ],
        );
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsObject($response);
        $this->assertEquals(self::DUMMY_ACCOUNT_UID, $response->accountUid);
        $this->assertEquals(self::DUMMY_ADDRESS_UID, $response->uid);

        $expectedProperties = [
            "uid",
            "accountUid",
            "addressType",
            "street",
            "streetNum",
            "city",
            "region",
            "country",
            "zip",
            "addressStatus",
            "relType",
            "sourceSystemCode",
        ];

        $this->assertObjectHasProperties($response, $expectedProperties);
    }

    public function testUpdateAddress()
    {
        $faker = (new AddressDto())->loadFromArray(self::DUMMY_RESPONSE);

        $mockResponse = new Response(json_encode($faker), 200);
        $httpClientMock = $this->getMockBuilder(KernelBrowser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $httpClientMock->method('getResponse')->willReturn($mockResponse);

        $this->client = $httpClientMock;
        $this->client->request(
            'PUT',
            '/api/accounts/' . self::DUMMY_ACCOUNT_UID . '/addresses/' . self::DUMMY_ADDRESS_UID,
            [
                'json' => self::DUMMY_PAYLOAD
            ],
        );
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsObject($response);
        $this->assertEquals(self::DUMMY_ACCOUNT_UID, $response->accountUid);
        $this->assertEquals(self::DUMMY_ADDRESS_UID, $response->uid);

        $expectedProperties = [
            "uid",
            "accountUid",
            "addressType",
            "street",
            "streetNum",
            "city",
            "region",
            "country",
            "zip",
            "addressStatus",
            "relType",
            "sourceSystemCode",
        ];

        $this->assertObjectHasProperties($response, $expectedProperties);
    }

    public function testUpdateAddressWithInvalidAddressUid()
    {
        $mockResponse = new Response('{}', 404);
        $httpClientMock = $this->getMockBuilder(KernelBrowser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $httpClientMock->method('getResponse')->willReturn($mockResponse);

        $this->client = $httpClientMock;
        $this->client->request(
            'PUT',
            '/api/accounts/' . self::DUMMY_ACCOUNT_UID . '/addresses/dummyAddressUid',
            [
                'json' => self::DUMMY_PAYLOAD
            ],
        );
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertSame(404, $this->client->getResponse()->getStatusCode());
        $this->assertIsObject($response);
    }
}
