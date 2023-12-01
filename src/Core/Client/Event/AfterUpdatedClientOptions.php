<?php

namespace App\Core\Client\Event;

use App\Core\Client\RequestOptions;
use Symfony\Contracts\EventDispatcher\Event;

class AfterUpdatedClientOptions extends Event
{
    public const NAME = 'client.after_updated_client_options';

    public function __construct(
        private readonly RequestOptions $requestOptions
    ) {
    }

    public function getRequestOptions(): array
    {
        return $this->requestOptions->toArray();
    }
}
