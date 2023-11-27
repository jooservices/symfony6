<?php

namespace App\Core\Client\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AfterUpdatedClientOptions extends Event
{
    const NAME = 'client.after_update_options';

    public function __construct(
        private readonly array $options
    ) {
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
