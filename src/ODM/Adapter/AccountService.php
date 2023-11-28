<?php

namespace App\ODM\Adapter;

use App\ODM\ODMAdapterInterface;

class AccountService
{
    public function __construct(private readonly ODMAdapterInterface $adapter)
    {
    }

    /**
     * @TODO Receive param by DTO and return DTO
     * @param string $id
     * @return void
     */
    public function getAccountById(string $id)
    {
        $response = $this->adapter->item($id);
        /**
         * @TODO Convert to DTO
         */
    }

    public function getAccounts(string $email)
    {
        $response = $this->adapter->list(['email' => $email]);
    }
}
