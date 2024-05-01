<?php

declare(strict_types=1);

namespace App\Invoice\Infrastructure\Persistence\Mock;

use App\Invoice\Domain\Invoice\Invoice;
use App\Invoice\Domain\Invoice\Repository\InvoiceRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class InvoiceRepositoryMock implements InvoiceRepositoryInterface
{
    /** @var array<array-key, Invoice> */
    private array $data;
    private ?Invoice $savedEntity = null;

    public function __construct(...$invoices)
    {
        $this->data = $invoices;
    }

    public function getTotalOpenInvoicesAmount(Uuid $debtorId): int
    {
        $res = 0;
        foreach ($this->data as $invoice) {
            if ($invoice->getDebtorId()->equals($debtorId)) {
                $res += $invoice->getAmount();
            }
        }

        return $res;
    }

    public function save(Invoice $invoice): void
    {
        $this->savedEntity = $invoice;
        $this->data[] = $invoice;
    }

    public function getSavedEntity(): Invoice
    {
        $entity = $this->savedEntity;
        \assert($entity instanceof Invoice);

        return $entity;
    }
}