<?php

namespace App\Core\Client\Event;

use App\Core\Client\RequestOptions;
use Symfony\Contracts\EventDispatcher\Event;

class BeforeUpdateClientOptions extends Event
{
    public const NAME = 'client.before_updated_client_options';

    public function __construct(
        private readonly RequestOptions $requestOptions
    ) {
    }

    public function getRequestOptions(): array
    {
        return $this->requestOptions->toArray();
    }
}
