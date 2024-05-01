<?php

declare(strict_types=1);

namespace App\Invoice\Infrastructure\Persistence\Doctrine\Repository;

use App\Invoice\Domain\Invoice\Invoice;
use App\Invoice\Domain\Invoice\Repository\InvoiceRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class InvoiceRepository implements InvoiceRepositoryInterface
{

    public function getTotalOpenInvoicesAmount(Uuid $debtorId): int
    {
        // TODO: Implement getTotalOpenInvoicesAmount() method.
    }

    public function save(Invoice $invoice): void
    {
        // TODO: Implement save() method.
    }
}