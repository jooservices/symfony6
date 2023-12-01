<?php

namespace App\Core\Client\EventSubscriber;

use App\Core\Client\Event\AfterClientRequested;
use App\Core\Client\Event\AfterUpdatedClientOptions;
use App\Core\Client\Event\BeforeClientRequest;
use App\Core\Client\Event\BeforeUpdateClientOptions;
use App\Document\RequestLog;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @TODO
 * - Write log to MongoDB
 */
class ClientRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly DocumentManager $documentManager
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
                AfterClientRequested::NAME => 'afterClientRequestedEvent',
        ];
    }

    public function afterClientRequestedEvent(AfterClientRequested $event): void
    {
        $requestLog = new RequestLog();
        $requestLog->setUrl($event->getUrl());
        $requestLog->setMethod($event->getMethod());
        $requestLog->setRequestOptions($event->getRequestOptions());
        $requestLog->setResponse($event->getResponse()->getContent());
        $requestLog->setStatusCode($event->getResponse()->getStatusCode());

        $this->documentManager->persist($requestLog);
        $this->documentManager->flush();
    }
}
