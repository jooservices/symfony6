<?php

namespace App\ApiModel\Resource\Address;

use OpenApi\Attributes as OA;

class AddressDto
{
    #[OA\Property(type: 'string', description: 'Address Uid', example: 'a93ff1ff-09ff-480c-9bc4-2a8da9bd2312', nullable: true)]
    public ?string $uid;

    #[OA\Property(type: 'string', description: 'Account Uid', example: 'a93ff1ff-09ff-480c-9bc4-2a8da9bd2das', nullable: true)]
    public ?string $accountUid;

    #[OA\Property(type: 'string', description: 'Address Name', example: 'dummy address')]
    public ?string $addressName;

    #[OA\Property(type: 'string', description: 'Address Type', example: 'DELIVERY', nullable: true)]
    public ?string $addressType;

    #[OA\Property(type: 'string', description: 'Street', example: 'someStreet')]
    public ?string $street;

    #[OA\Property(type: 'string', description: 'Street Number', example: '123')]
    public ?string $streetNum;

    #[OA\Property(type: 'string', description: 'City', example: 'someCity')]
    public ?string $city;

    #[OA\Property(type: 'string', description: 'Region', example: 'someRegion')]
    public ?string $region;

    #[OA\Property(type: 'string', description: 'Country', example: 'someCountry')]
    public ?string $country;

    #[OA\Property(type: 'string', description: 'ZIP Code', example: '123456')]
    public ?string $zip;

    #[OA\Property(type: 'string', description: 'Address Status', example: 'Active')]
    public ?string $addressStatus;

    #[OA\Property(type: 'string', description: 'Relation Type', example: 'MAIN')]
    public ?string $relType;

    #[OA\Property(type: 'string', description: 'Source Timestamp', example: '2023-11-18T18:51:13.176Z', nullable: false)]
    public ?string $sourceTimestamp;

    #[OA\Property(type: 'string', description: 'Source System Code', example: 'cop', nullable: false)]
    public string $sourceSystemCode;

    public function loadFromArray(array $data): self
    {
        $this->uid = $data['externalAddressId'] ?? null;
        $this->accountUid = $data['externalAccountId'] ?? null;
        $this->addressName = $data['addressName'] ?? null;
        $this->addressType = $data['addressType'];
        $this->street = $data['street'];
        $this->streetNum = $data['streetNum'];
        $this->city = $data['city'];
        $this->region = $data['region'];
        $this->country = $data['country'];
        $this->zip = $data['zip'];
        $this->addressStatus = $data['addressStatus'];
        $this->relType = $data['relType'];
        $this->sourceTimestamp = $data['sourceTimestamp'] ?? null;
        $this->sourceSystemCode = $data['sourceSystemCode'];

        return $this;
    }
}
