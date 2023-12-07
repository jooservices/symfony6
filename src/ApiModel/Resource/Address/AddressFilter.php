<?php

namespace App\ApiModel\Resource\Address;

use OpenApi\Attributes as OA;
use App\ApiModel\Resource\Trait\ArrayMappable;
use Symfony\Component\Validator\Constraints as Assert;

class AddressFilter
{
    use ArrayMappable;

    #[OA\Property(type: 'string', description: 'Account Uid', example: 'a93ff1ff-09ff-480c-9bc4-2a8da9bd2312', nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $accountUid;

    public function __construct(array $data = null)
    {
        $this->mapArray($data, []);
    }
}
