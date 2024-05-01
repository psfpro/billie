<?php

declare(strict_types=1);

namespace App\Common\Bus;

interface QueryBusInterface
{
    public function dispatch(object $query): object;
}