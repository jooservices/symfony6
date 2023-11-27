<?php

namespace App\Core\Client\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AfterUpdatedClientOptions extends Event
{
    public const NAME = 'client.after_updated_client_options';

    public function __construct(
        private readonly array $options
    ) {
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
