<?php

declare(strict_types=1);

namespace App\Common\Bus\Messenger;

use App\Common\Bus\EventBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

final class EventBus implements EventBusInterface
{
    protected MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function dispatch(object $event): void
    {
        try {
            $this->eventBus->dispatch($event, [new DispatchAfterCurrentBusStamp()]);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious() ?? $e;
        }
    }
}