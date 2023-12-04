<?php

namespace App\ApiModel\Resource\Contract;

use OpenApi\Attributes as OA;

class ContractDto
{
    #[OA\Property(description: 'ID', example: 0, nullable: false)]
    public ?int $id = null;

    #[OA\Property(description: 'Contract Uuid', example: 'contract01', nullable: false)]
    public ?string $contractUuid = null;

    #[OA\Property(description: 'Contract Type', example: 'string', nullable: false)]
    public ?string $contractType = null;

    #[OA\Property(description: 'Created Date', example: 'string', nullable: false)]
    public ?string $createdDate = null;

    #[OA\Property(description: 'Valide From', example: 'string', nullable: false)]
    public ?string $validFrom = null;

    #[OA\Property(description: 'Valid To', example: 'string', nullable: false)]
    public ?string $validTo = null;

    #[OA\Property(description: 'lastModifiedDate', example: 'string', nullable: false)]
    public ?string $lastModifiedDate = null;

    #[OA\Property(description: 'contractStatus', example: 'string', nullable: false)]
    public ?string $contractStatus = null;

    #[OA\Property(description: 'priceListId', example: 'string', nullable: false)]
    public ?string $priceListId = null;

    #[OA\Property(description: 'zuoraSubscriptionNumber', example: 'string', nullable: false)]
    public ?string $zuoraSubscriptionNumber = null;

    #[OA\Property(description: 'zuoraFiscalSubscriptionNumber', example: 'string', nullable: false)]
    public ?string $zuoraFiscalSubscriptionNumber = null;

    #[OA\Property(description: 'Source System Code', example: 'string', nullable: false)]
    public ?string $sourceSystemCode = null;

    public function loadFromArray(array $data): self
    {
        $this->id = $data['id'];
        $this->contractUuid = $data['externalContractId'];
        $this->contractType = $data['contractType'];
        $this->createdDate = $data['createdDate'];
        $this->validFrom = $data['validFrom'];
        $this->validTo = $data['validTo'];
        $this->lastModifiedDate = $data['lastModifiedDate'];
        $this->contractStatus = $data['contractStatus'];
        $this->priceListId = $data['priceListId'];
        $this->zuoraSubscriptionNumber = $data['zuoraSubscriptionNumber'];
        $this->zuoraFiscalSubscriptionNumber = $data['zuoraFiscalSubscriptionNumber'];
        $this->sourceSystemCode = $data['sourceSystemCode'];

        return $this;
    }
}
