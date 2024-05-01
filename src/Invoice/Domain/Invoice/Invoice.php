<?php

declare(strict_types=1);

namespace App\Invoice\Domain\Invoice;

use Symfony\Component\Uid\Uuid;

final class Invoice
{
    private Uuid $id;
    private Uuid $debtorId;
    private Uuid $creditorId;
    private int $amount;
    private \DateTimeImmutable $issueDate;
    private \DateTimeImmutable $dueDate;
    private InvoiceStatus $status;

    public function __construct(
        Uuid $id,
        Uuid $debtorId,
        Uuid $creditorId,
        int $amount,
        \DateTimeImmutable $issueDate,
        \DateTimeImmutable $dueDate,
    ) {
        $this->id = $id;
        $this->debtorId = $debtorId;
        $this->creditorId = $creditorId;
        $this->amount = $amount;
        $this->issueDate = $issueDate;
        $this->dueDate = $dueDate;
        $this->status = InvoiceStatus::Open;
    }

    public function markAsPaid(): void
    {
        $this->status = InvoiceStatus::Paid;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getDebtorId(): Uuid
    {
        return $this->debtorId;
    }

    public function getCreditorId(): Uuid
    {
        return $this->creditorId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getIssueDate(): \DateTimeImmutable
    {
        return $this->issueDate;
    }

    public function getDueDate(): \DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function getStatus(): InvoiceStatus
    {
        return $this->status;
    }
}