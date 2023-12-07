<?php

namespace App\ODM;

use App\ApiModel\Resource\Address\AddressDto;
use App\ApiModel\Resource\Address\AddressFilter;
use App\ApiModel\Resource\Address\AddressList;
use App\ApiModel\Resource\Errors\HttpError;
use App\ApiModel\Resource\PagingMeta;
use App\ODM\ODMAdapterInterface;
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddressService
{
    public function __construct(private readonly ODMAdapterInterface $adapter)
    {
    }

    /**
     * @return AddressList|JsonResponse
     */
    public function list(AddressFilter $dto)
    {
        try {
            $query = [
                'externalAccountId' => $dto->accountUid,
            ];

            $response = $this->adapter->list($query);

            $output = new AddressList();
            $output->data = array_map(fn ($item) => (new AddressDto())->loadFromArray($item), $response);

            $meta = new PagingMeta();
            $meta->totalPages = 1;
            $meta->totalRecords = $output->data ? count($output->data) : 0;
            $meta->currentPage = 1;
            $meta->pageSize = 1;
            $output->meta = $meta;

            return $output;
        } catch (Exception $e) {
            return new JsonResponse(new HttpError($e->getMessage()), $e->getCode());
        }
    }

    /**
     * @return AddressDto|JsonResponse
     */
    public function create(AddressDto $dto, string $accountUid)
    {
        try {
            $payload = $this->getPayload($dto, $accountUid);
            $response = $this->adapter->create(['json' => $payload]);

            return (new AddressDto())->loadFromArray($response);
        } catch (Exception $e) {
            return new JsonResponse(new HttpError($e->getMessage()), $e->getCode());
        }
    }

    /**
     * @return AddressDto|JsonResponse
     */
    public function update(AddressDto $dto, string $addressUid, string $accountUid)
    {
        try {
            $payload = $this->getPayload($dto, $accountUid);
            $response = $this->adapter->update($addressUid, ['json' => $payload]);

            return (new AddressDto())->loadFromArray($response);
        } catch (Exception $e) {
            return new JsonResponse(new HttpError($e->getMessage()), $e->getCode());
        }
    }

    private function getPayload(AddressDto $dto, string $accountUid): array
    {
        $payload = (array)$dto;
        $payload['sourceSystemCode'] = 'cop';
        $payload['sourceTimestamp'] = (new Carbon())->now();
        $payload['addressType'] = 'DELIVERY';
        $payload['relType'] = 'MAIN';
        $payload['externalAccountId'] = $accountUid;

        return $payload;
    }
}