<?php

declare(strict_types=1);

namespace App\Invoice\Domain\Invoice\Repository;

use App\Invoice\Domain\Invoice\Invoice;
use Symfony\Component\Uid\Uuid;

interface InvoiceRepositoryInterface
{
    public function getTotalOpenInvoicesAmount(Uuid $debtorId): int;

    public function save(Invoice $invoice): void;
}