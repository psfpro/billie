<?php

declare(strict_types=1);

namespace App\Invoice\Domain\DebtorLimit;

use Symfony\Component\Uid\Uuid;

final class DebtorLimit
{
    private Uuid $id;
    private Uuid $debtorId;
    private int $limitAmount;
    private int $currentUtilizedAmount;

    public function __construct(
        Uuid $id,
        Uuid $debtorId,
        int $limitAmount,
        int $currentUtilizedAmount,
    ) {
        $this->id = $id;
        $this->debtorId = $debtorId;
        $this->limitAmount = $limitAmount;
        $this->currentUtilizedAmount = $currentUtilizedAmount;
    }

    public function updateLimit(int $limitAmount): void
    {
        $this->limitAmount = $limitAmount;
    }

    public function calculateRemainingCredit()
    {

    }

    public function canAcceptInvoice()
    {
        
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getDebtorId(): Uuid
    {
        return $this->debtorId;
    }

    public function getLimitAmount(): int
    {
        return $this->limitAmount;
    }

    public function getCurrentUtilizedAmount(): int
    {
        return $this->currentUtilizedAmount;
    }
}