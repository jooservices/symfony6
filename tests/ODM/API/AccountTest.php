<?php

namespace App\Tests\ODM\API;

use App\ODM\API\Account;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AccountTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->bootKernel();
    }

    public function testGetAccountByIdSuccess()
    {
        $account = $this->getContainer()->get(Account::class);

        $response = $account->getAccountById('account01');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->isSuccess());
    }
}
