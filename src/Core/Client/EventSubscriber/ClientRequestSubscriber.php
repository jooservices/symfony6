<?php

namespace App\Core\Client\EventSubscriber;

use App\Core\Client\Event\AfterClientRequested;
use App\Core\Client\Event\AfterUpdatedClientOptions;
use App\Core\Client\Event\BeforeClientRequest;
use App\Core\Client\Event\BeforeUpdateClientOptions;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @TODO
 * - Write log to MongoDB
 */
class ClientRequestSubscriber implements EventSubscriberInterface
{
    public function afterClientRequestedEvent(AfterClientRequested $event): void
    {
    }

    public function afterUpdatedClientOptions(AfterUpdatedClientOptions $event): void
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
                BeforeClientRequest::NAME => 'beforeClientRequestEvent',
                AfterClientRequested::NAME => 'afterClientRequestedEvent',
                BeforeUpdateClientOptions::NAME => 'beforeUpdateOptionsEvent',
                AfterUpdatedClientOptions::NAME => 'afterUpdatedClientOptions',
        ];
    }

    public function beforeClientRequestEvent(BeforeClientRequest $event): void
    {
    }

    public function beforeUpdateOptionsEvent(BeforeClientRequest $event): void
    {
    }
}
