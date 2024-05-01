<?php

declare(strict_types=1);

namespace App\Common\Bus;

interface EventBusInterface
{
    public function dispatch(object $event): void;
}