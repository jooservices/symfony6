<?php

namespace App\ApiModel\Resource\Account;

use OpenApi\Attributes as OA;

class ContactDto
{
    #[OA\Property(description: 'Contact ID', example: 'string', nullable: false)]
    public ?string $contactId = null;

    #[OA\Property(description: 'Contact Type', example: 'string', nullable: false)]
    public ?string $contactType = null;

    #[OA\Property(description: 'Value', example: 'string', nullable: false)]
    public ?string $value = null;

    #[OA\Property(description: 'Contact Status', example: 'string', nullable: false)]
    public ?string $contactStatus = null;

    #[OA\Property(description: 'Rel Type', example: 'string', nullable: false)]
    public ?string $relType = null;

    #[OA\Property(description: 'Source System Code', example: 'string', nullable: false)]
    public ?string $sourceSystemCode = null;

    public function loadFromArray(array $data): self
    {
        $this->contactId = $data['externalContactId'];
        $this->contactType = $data['contactType'];
        $this->value = $data['value'];
        $this->contactStatus = $data['contactStatus'];
        $this->relType = $data['relType'];
        $this->sourceSystemCode = $data['sourceSystemCode'];

        return $this;
    }
}
