<?php

namespace App\ODM;

use App\ApiModel\Resource\Contract\ContractDto;
use App\ApiModel\Resource\Errors\HttpError;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContractService
{
    public function __construct(private readonly ODMAdapterInterface $adapter)
    {
    }

    /**
     * @return ContractDto|JsonResponse
     */
    public function getContractByUuid(string $uuid)
    {
        try {
            $response = $this->adapter->item($uuid);
            $contract = new ContractDto();
            $contract->loadFromArray($response);

            return $contract;
        } catch (Exception $e) {
            return new JsonResponse(new HttpError($e->getMessage()), $e->getCode());
        }
    }

    /**
     * @return ContractDto[]|JsonResponse
     */
    public function getContracts(string $accountUuid)
    {
        try {
            $response = $this->adapter->list(['externalAccountId' => $accountUuid]);

            return array_map(fn ($item) => (new ContractDto())->loadFromArray($item), $response);
        } catch (Exception $e) {
            return new JsonResponse(new HttpError($e->getMessage()), $e->getCode());
        }
    }
}
