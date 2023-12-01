<?php

declare(strict_types=1);

namespace App\ApiModel\Resource\Errors;

use OpenApi\Attributes as OA;

#[OA\Schema(required: [
    'message',
])]
class HttpError
{
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    #[OA\Property(description: 'General error description', example: 'The data you sent are not valid', nullable: false)]
    public string $message;
}
