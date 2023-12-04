<?php

namespace App\Tests\Services;

use App\ApiModel\Resource\Contract\ContractDto;
use App\ODM\ContractService;
use App\ODM\ODMAdapterInterface;
use App\Tests\AssertHelper;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContractServiceTest extends KernelTestCase
{
    use AssertHelper;

    private MockObject $adapter;
    private array $faker = [
        'id' => 1,
        'externalContractId' => 'contract01',
        'contractType' => 'Contract',
        'createdDate' => '2022-01-01',
        'validFrom' => '2022-01-01',
        'validTo' => '2022-01-01',
        'lastModifiedDate' => '2022-01-01',
        'contractStatus' => 'Active',
        'priceListId' => 1,
        'zuoraSubscriptionNumber' => '123',
        'zuoraFiscalSubscriptionNumber' => '123',
        'sourceSystemCode' => 'Zuora',
    ];
    private array $expectedProperties = [
        'id',
        'contractUuid',
        'contractType',
        'createdDate',
        'validFrom',
        'validTo',
        'lastModifiedDate',
        'contractStatus',
        'priceListId',
        'zuoraSubscriptionNumber',
        'zuoraFiscalSubscriptionNumber',
        'sourceSystemCode',
     ];

    public function setUp(): void
    {
        parent::setUp();
        $this->bootKernel();

        $this->adapter = $this->createMock(ODMAdapterInterface::class);
    }
    public function testGetContractByUuid()
    {
        $contractUuid = 'contract01';

        $this->adapter->expects($this->once())
            ->method('item')
            ->with($contractUuid)
            ->willReturn($this->faker);

        $contractService = new ContractService($this->adapter);

        $contract = $contractService->getContractByUuid($contractUuid);

        $this->assertInstanceOf(ContractDto::class, $contract);
        
        $this->assertEquals($this->faker['externalContractId'], $contract->contractUuid);
        $this->assertEquals($this->faker['contractType'], $contract->contractType);
        $this->assertObjectHasProperties($contract, $this->expectedProperties);
    }

    public function testGetContracts()
    {
        $accountUuid = 'dummyAccount';

        $this->adapter->expects($this->once())
            ->method('list')
            ->with(['externalAccountId' => $accountUuid])
            ->willReturn([$this->faker]);

        $contractService = new ContractService($this->adapter);

        $contracts = $contractService->getContracts($accountUuid);

        $this->assertIsArray($contracts);
        $this->assertEquals($this->faker['externalContractId'], $contracts[0]->contractUuid);
        $this->assertEquals($this->faker['contractType'], $contracts[0]->contractType);
        $this->assertObjectHasProperties($contracts[0], $this->expectedProperties);
    }
}
