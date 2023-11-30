<?php

namespace App\Tests\Controllers;

use App\Tests\AssertHelper;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    use AssertHelper;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testRetrieveAccountByUuid()
    {
        $this->client->request('GET', '/api/accounts/account01');
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseFormatSame('json');

        $this->assertIsObject($response);
        $this->assertEquals('account01', $response->accountUuid);

        $expectedProperties = [
            'id',
            'accountUuid',
            'companyName',
            'companyNameLocal',
            'companyType',
            'companyRegNo',
            'companyVAT',
            'accountStatus',
            'zuoraAccountId',
            'zuoraAccountNumber',
            'people',
            'bankAccounts',
            'sourceSystemCode',
        ];

        $this->assertObjectHasProperties($response, $expectedProperties);
    }

    public function testRetrieveAccountByInvalidUuid()
    {
        $this->client->request('GET', '/api/accounts/account-test');

        $this->assertResponseStatusCodeSame(500);
    }

    public function testRetrieveAccountByEmail()
    {
        $this->client->request('GET', '/api/accounts/', ['email' => 'test@sodexo.com']);
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseFormatSame('json');
        $this->assertIsArray($response);
        $this->assertEquals('test@sodexo.com', $response[0]->people[0]->contacts[0]->value);

        $expectedProperties = [
            'id',
            'accountUuid',
            'companyName',
            'companyNameLocal',
            'companyType',
            'companyRegNo',
            'companyVAT',
            'accountStatus',
            'zuoraAccountId',
            'zuoraAccountNumber',
            'people',
            'bankAccounts',
            'sourceSystemCode',
        ];

        $this->assertObjectHasProperties($response[0], $expectedProperties);
    }

    public function testRetrieveAccountByEmailWithWrongParam()
    {
        $this->client->request('GET', '/api/accounts/', ['phone' => '+849288123']);
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseFormatSame('json');
        $this->assertEquals('Email is required', $response->message);
    }
}
