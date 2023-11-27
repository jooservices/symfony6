<?php

namespace App\Core\Client\Event;

use Symfony\Contracts\EventDispatcher\Event;

class BeforeUpdateClientOptions extends Event
{
    public const NAME = 'client.before_updated_client_options';

    public function __construct(
        private readonly array $options
    ) {
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
