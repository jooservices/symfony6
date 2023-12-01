<?php

namespace App\ApiModel\Resource\Account;

use OpenApi\Attributes as OA;

class BankAccountDto
{
    #[OA\Property(description: 'Bank Account ID', example: 'string', nullable: false)]
    public ?string $bankAccountId = null;

    #[OA\Property(description: 'Bank Account Type', example: 'string', nullable: true)]
    public ?string $bankAccountType = null;

    #[OA\Property(description: 'Bank Account Number', example: 'string', nullable: true)]
    public ?string $bankAccountNumber = null;

    #[OA\Property(description: 'Bank Account Status', example: 'string', nullable: true)]
    public ?string $bankAccountStatus = null;

    #[OA\Property(description: 'Bank Code', example: 'string', nullable: true)]
    public ?string $bankCode = null;

    #[OA\Property(description: 'Prefix Bank Account Number', example: 'string', nullable: true)]
    public ?string $prefixBankAccountNumber = null;

    #[OA\Property(description: 'Rel Type', example: 'string', nullable: true)]
    public ?string $relType = null;

    #[OA\Property(description: 'Source System Code', example: 'string', nullable: true)]
    public ?string $sourceSystemCode = null;

    #[OA\Property(description: 'Iban', example: 'string', nullable: true)]
    public ?string $iban = null;

    public function loadFromArray(array $data): self
    {
        $this->bankAccountId = $data['externalBankAccountId'];
        $this->bankAccountType = $data['bankAccountType'];
        $this->bankAccountNumber = $data['bankAccountNumber'];
        $this->bankAccountStatus = $data['bankAccountStatus'];
        $this->bankCode = $data['bankCode'];
        $this->prefixBankAccountNumber = $data['prefixBankAccountNumber'];
        $this->relType = $data['relType'];
        $this->sourceSystemCode = $data['sourceSystemCode'];
        $this->iban = $data['iban'];

        return $this;
    }
}
