<?php

namespace App\ApiModel\Resource\Account;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class AccountDto
{
    #[OA\Property(description: 'ID', example: 0, nullable: false)]
    public ?int $id = null;

    #[OA\Property(description: 'Account Uuid', example: '1d0c9f65-fe3b-4fea-bdd0-b9644d518a5b', nullable: false)]
    public ?string $accountUuid = null;

    #[OA\Property(description: 'Company Name', example: 'Pluxee', nullable: false)]
    public ?string $companyName = null;

    #[OA\Property(description: 'Company Name Local', example: 'Pluxee', nullable: false)]
    public ?string $companyNameLocal = null;

    #[OA\Property(description: 'Company Type', example: 'Inc.', nullable: false)]
    public ?string $companyType = null;

    #[OA\Property(description: 'Company RegNo', example: '123456789', nullable: false)]
    public ?string $companyRegNo = null;

    #[OA\Property(description: 'Company VAT ID', example: 'CZ123456789', nullable: false)]
    public ?string $companyVAT = null;

    #[OA\Property(description: 'Account Status', example: 'TODO', nullable: false)]
    public ?string $accountStatus = null;

    #[OA\Property(description: 'Zuora Account Id', example: 'TODO', nullable: false)]
    public ?string $zuoraAccountId = null;

    #[OA\Property(description: 'Zuora Account Id', example: 'TODO', nullable: false)]
    public ?string $zuoraAccountNumber = null;

    #[OA\Property(type: 'array', items: new OA\Items(ref: new Model(type: PeopleDto::class)), nullable: false)]
    public array $people = [];

    #[OA\Property(type: 'array', items: new OA\Items(ref: new Model(type: BankAccountDto::class)), nullable: false)]
    public array $bankAccounts = [];

    #[OA\Property(description: 'Source System Code', example: 'string', nullable: false)]
    public ?string $sourceSystemCode = null;

    public function loadFromArray(array $data): self
    {
        $this->id = $data['id'];
        $this->accountUuid = $data['externalAccountId'];
        $this->companyName = $data['companyName'];
        $this->companyNameLocal = $data['companyNameLocal'];
        $this->companyType = $data['companyType'];
        $this->companyRegNo = $data['companyRegNo'];
        $this->companyVAT = $data['companyVAT'];
        $this->accountStatus = $data['accountStatus'];
        $this->zuoraAccountId = $data['zuoraAccountId'];
        $this->zuoraAccountNumber = $data['zuoraAccountNumber'];

        if (!empty($data['people'])) {
            $mappedPeople = array_map(function ($item) {
                $person = new PeopleDto();

                $person->loadFromArray($item);

                return $person;
            }, $data['people']);

            $this->people = $mappedPeople;
        }

        if (!empty($data['bankAccounts'])) {
            $mappedBankAccounts = array_map(function ($item) {
                $bankAccount = new BankAccountDto();

                $bankAccount->loadFromArray($item);

                return $bankAccount;
            }, $data['bankAccounts']);

            $this->bankAccounts = $mappedBankAccounts;
        }

        $this->sourceSystemCode = $data['sourceSystemCode'];

        return $this;
    }
}
