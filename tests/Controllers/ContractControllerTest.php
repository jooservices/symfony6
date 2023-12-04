<?php

namespace App\Tests\Controllers;

use App\ApiModel\Resource\Contract\ContractDto;
use App\Tests\AssertHelper;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContractControllerTest extends WebTestCase
{
    use AssertHelper;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testRetrieveContractByUuid()
    {
        $faker = [
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

        $contractDto = (new ContractDto)->loadFromArray($faker);

         $mockResponse = new Response(json_encode($contractDto), 200);
         $httpClientMock = $this->getMockBuilder(KernelBrowser::class)
            ->disableOriginalConstructor()
            ->getMock();
         $httpClientMock->method('getResponse')->willReturn($mockResponse);
 
         $this->client = $httpClientMock;
         $this->client->request('GET', '/api/contracts/contract01');
         $response = json_decode($this->client->getResponse()->getContent());
 
         $this->assertSame(200, $this->client->getResponse()->getStatusCode());
         $this->assertIsObject($response);
         $this->assertEquals('contract01', $response->contractUuid);
 
         $expectedProperties = [
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
 
         $this->assertObjectHasProperties($response, $expectedProperties);
    }

    public function testRetrieveContractByInvalidUuid()
    {
        $this->client->request('GET', '/api/contracts/contract-test');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testRetrieveContractsByAccountUuid()
    {
        $this->client->request('GET', '/api/contracts/', ['accountUuid' => 'account01']);
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseFormatSame('json');
        $this->assertIsArray($response);
    }

    public function testRetrieveContractByAccountUuidWithWrongParam()
    {
        $this->client->request('GET', '/api/contracts/', ['phone' => '12345678']);
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseFormatSame('json');
        $this->assertEquals('accountUuid is required', $response->message);
    }
}
