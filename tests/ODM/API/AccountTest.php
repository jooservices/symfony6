<?php

namespace App\Tests\ODM\API;

use App\ApiModel\Resource\Account\AccountDto;
use App\ODM\AccountService;
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
         $account = $this->getContainer()->get(AccountService::class);

         $response = $account->getAccountByUuid('account01');
         $this->assertTrue($response instanceof AccountDto);
     }
}
