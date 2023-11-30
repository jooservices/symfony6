<?php

namespace App\ODM;

use App\ApiModel\Resource\Account\AccountDto;

class AccountService
{
    public function __construct(private readonly ODMAdapterInterface $adapter)
    {
    }

    public function getAccountByUuid(string $uuid): AccountDto
    {
        $response = $this->adapter->item($uuid);
        $account = new AccountDto();
        $account->loadFromArray($response);

        return $account;
    }

    /**
     * @return AccountDto[]
     */
    public function getAccounts(string $email): array
    {
        $response = $this->adapter->list(['email' => $email]);

        if (empty($response)) {
            return [];
        }

        return array_map(function ($item) {
            $account = new AccountDto();
            return $account->loadFromArray($item);
        }, $response);
    }
}
