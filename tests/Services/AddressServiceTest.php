<?php

namespace App\Tests\Services;

use App\ApiModel\Resource\Address\AddressDto;
use App\ApiModel\Resource\Address\AddressFilter;
use App\ApiModel\Resource\Address\AddressList;
use App\ODM\AddressService;
use App\ODM\ODMAdapterInterface;
use App\Tests\AssertHelper;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddressServiceTest extends KernelTestCase
{
    use AssertHelper;

    private MockObject $adapter;
    private AddressService $service;

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
    private array $expectedProperties = [
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

    public function setUp(): void
    {
        parent::setUp();
        $this->bootKernel();

        $this->adapter = $this->createMock(ODMAdapterInterface::class);
        $this->service = new AddressService($this->adapter);
    }

    public function testGetAddressesByAccountUid()
    {
        $this->adapter->expects($this->once())
            ->method('list')
            ->with(['externalAccountId' => self::DUMMY_ACCOUNT_UID])
            ->willReturn([self::DUMMY_RESPONSE]);

        $filter = new AddressFilter(['accountUid' => self::DUMMY_ACCOUNT_UID]);
        $addresses = $this->service->list($filter);

        $this->assertInstanceOf(AddressList::class, $addresses);
        $this->assertEquals(self::DUMMY_ADDRESS_UID, $addresses->data[0]->uid);
        $this->assertEquals(self::DUMMY_ACCOUNT_UID, $addresses->data[0]->accountUid);
        $this->assertEquals(1, count($addresses->data));
        $this->assertObjectHasProperties($addresses->data[0], $this->expectedProperties);
    }

    public function testCreateAddress()
    {
        $this->adapter->expects($this->once())
            ->method('create')
            ->willReturn(self::DUMMY_RESPONSE);

        $address = $this->service->create(
            (new AddressDto())->loadFromArray(self::DUMMY_PAYLOAD),
            self::DUMMY_ACCOUNT_UID
        );

        $this->assertInstanceOf(AddressDto::class, $address);
        $this->assertEquals(self::DUMMY_ADDRESS_UID, $address->uid);
        $this->assertEquals(self::DUMMY_ACCOUNT_UID, $address->accountUid);
        $this->assertObjectHasProperties($address, $this->expectedProperties);
    }

    public function testUpdateAddress()
    {
        $this->adapter->expects($this->once())
            ->method('update')
            ->willReturn(self::DUMMY_RESPONSE);

        $address = $this->service->update(
            (new AddressDto())->loadFromArray(self::DUMMY_PAYLOAD),
            self::DUMMY_ADDRESS_UID,
            self::DUMMY_ACCOUNT_UID,
        );

        $this->assertInstanceOf(AddressDto::class, $address);
        $this->assertEquals(self::DUMMY_ADDRESS_UID, $address->uid);
        $this->assertEquals(self::DUMMY_ACCOUNT_UID, $address->accountUid);
        $this->assertObjectHasProperties($address, $this->expectedProperties);
    }
}
