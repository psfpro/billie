<?php

declare(strict_types=1);

namespace App\Invoice\Domain\Invoice;

enum InvoiceStatus: string
{
    case Open = 'Open';
    case Paid = 'Paid';
    case Overdue = 'Overdue';

    public function isOpen(): bool
    {
        return $this === self::Open;
    }

    public function isPaid(): bool
    {
        return $this === self::Paid;
    }

    public function iOverdue(): bool
    {
        return $this === self::Overdue;
    }
}
