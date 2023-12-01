<?php

namespace App\ApiModel\Resource\Account;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class PeopleDto
{
    #[OA\Property(description: 'ID', example: 'string', nullable: false)]
    public ?string $personId = null;

    #[OA\Property(description: 'Contact Type', example: 'string', nullable: false)]
    public ?string $contactType = null;

    #[OA\Property(description: 'First Name', example: 'string', nullable: false)]
    public ?string $firstName = null;

    #[OA\Property(description: 'Middle Name', example: 'string', nullable: false)]
    public ?string $middleName = null;

    #[OA\Property(description: 'Last Name', example: 'string', nullable: false)]
    public ?string $lastName = null;

    #[OA\Property(description: 'First Name Local', example: 'string', nullable: false)]
    public ?string $firstNameLocal = null;

    #[OA\Property(description: 'Middle Name Local', example: 'string', nullable: false)]
    public ?string $middleNameLocal = null;

    #[OA\Property(description: 'Last Name Local', example: 'string', nullable: false)]
    public ?string $lastNameLocal = null;

    #[OA\Property(description: 'Company Position', example: 'string', nullable: false)]
    public ?string $companyPosition = null;

    #[OA\Property(description: 'Person Status', example: 'string', nullable: false)]
    public ?string $personStatus = null;

    #[OA\Property(description: 'Role Type', example: 'string', nullable: false)]
    public ?string $roleType = null;

    #[OA\Property(description: 'Source System Code', example: 'string', nullable: false)]
    public ?string $sourceSystemCode = null;

    #[OA\Property(type: 'array', items: new OA\Items(ref: new Model(type: ContactDto::class)), nullable: false)]
    public array $contacts = [];

    public function loadFromArray(array $data): self
    {
        $this->personId = $data['externalPersonId'];
        $this->contactType = $data['contactType'];
        $this->firstName = $data['firstName'];
        $this->middleName = $data['middleName'];
        $this->lastName = $data['lastName'];
        $this->firstNameLocal = $data['firstNameLocal'];
        $this->middleNameLocal = $data['middleNameLocal'];
        $this->lastNameLocal = $data['lastNameLocal'];
        $this->companyPosition = $data['companyPosition'];
        $this->personStatus = $data['personStatus'];
        $this->roleType = $data['roleType'];
        $this->sourceSystemCode = $data['sourceSystemCode'];

        if (!empty($data['contacts'])) {
            $mappedContacts = array_map(function ($item) {
                $contact = new ContactDto();

                $contact->loadFromArray($item);

                return $contact;
            }, $data['contacts']);

            $this->contacts = $mappedContacts;
        }

        return $this;
    }
}
