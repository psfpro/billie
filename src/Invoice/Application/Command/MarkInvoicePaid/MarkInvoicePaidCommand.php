<?php

declare(strict_types=1);

namespace App\Invoice\Application\Command\MarkInvoicePaid;

use Symfony\Component\Uid\Uuid;

final class MarkInvoicePaidCommand
{
    public function __construct(
        public Uuid $id,
    ) {
    }
}