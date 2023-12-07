<?php

namespace App\ApiModel\Resource\Address;

use App\ApiModel\Resource\PagingMeta;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[OA\Schema(required: [
    'data',
    'meta',
])]
class AddressList
{
    #[OA\Property(type: 'array', items: new OA\Items(ref: new Model(type: AddressDto::class)), nullable: false)]
    public array $data = [];

    #[OA\Property(ref: new Model(type: PagingMeta::class))]
    public ?PagingMeta $meta = null;
}
