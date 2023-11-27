<?php

namespace App\ODM\API;

use App\Core\Client\Response\ResponseInterface;
use App\ODM\ODMClient;

class Account
{
    public function __construct(private ODMClient $client)
    {
    }

    /**
     * @TODO Return by DTO
     * @param string $accountUid
     * @return ResponseInterface
     */
    public function getAccountById(string $accountUid)
    {
        /**
         * @TODO Catch exception
         * - Our develop don't need to know / handle issue from ODM
         */
        return $this->client->get('api/v1/external/account/' . $accountUid);
    }
}
