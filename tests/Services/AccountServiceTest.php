<?php

namespace App\Tests\Services;

use App\ApiModel\Resource\Account\AccountDto;
use App\ODM\AccountService;
use App\ODM\ODMAdapterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AccountServiceTest extends KernelTestCase
{
    private MockObject $adapter;

    public function setUp(): void
    {
        parent::setUp();
        $this->bootKernel();

        $this->adapter = $this->createMock(ODMAdapterInterface::class);
    }
    public function testGetAccountByUuid()
    {
        $accountUuid = '123456789';
        $response = [
            'id' => 0,
            'externalAccountId' => $accountUuid,
            'companyName' => 'John Doe',
            'companyNameLocal' => 'John Doe',
            'companyType' => 'company',
            'companyRegNo' => '123456',
            'companyVAT' => '123456',
            'accountStatus' => 'active',
            'zuoraAccountId' => '123456',
            'zuoraAccountNumber' => '123456',
            'people' => [],
            'bankAccounts' => [],
            'sourceSystemCode' => 'op',
        ];

        $this->adapter->expects($this->once())
            ->method('item')
            ->with($accountUuid)
            ->willReturn($response);

        $accountService = new AccountService($this->adapter);

        $account = $accountService->getAccountByUuid($accountUuid);

        $this->assertInstanceOf(AccountDto::class, $account);
        $this->assertEquals($response['externalAccountId'], $account->accountUuid);
        $this->assertEquals($response['companyName'], $account->companyName);
    }

    public function testGetAccountByEmail()
    {
        $email = 'email@example.com';
        $response = [
            'id' => 0,
            'externalAccountId' => 'accountUuid',
            'companyName' => 'John Doe',
            'companyNameLocal' => 'John Doe',
            'companyType' => 'company',
            'companyRegNo' => '123456',
            'companyVAT' => '123456',
            'accountStatus' => 'active',
            'zuoraAccountId' => '123456',
            'zuoraAccountNumber' => '123456',
            'people' => [],
            'bankAccounts' => [],
            'sourceSystemCode' => 'op',
        ];

        $this->adapter->expects($this->once())
            ->method('list')
            ->with(['email' => $email])
            ->willReturn([$response]);

        $accountService = new AccountService($this->adapter);

        $accounts = $accountService->getAccounts($email);

        $this->assertIsArray($accounts);
        $this->assertEquals($response['externalAccountId'], $accounts[0]->accountUuid);
        $this->assertEquals($response['companyName'], $accounts[0]->companyName);
    }
}
