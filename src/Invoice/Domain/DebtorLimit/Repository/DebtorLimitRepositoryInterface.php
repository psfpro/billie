<?php

declare(strict_types=1);

namespace App\Invoice\Domain\DebtorLimit\Repository;

use App\Invoice\Domain\DebtorLimit\DebtorLimit;
use Symfony\Component\Uid\Uuid;

interface DebtorLimitRepositoryInterface
{
    public function findDebtorLimit(Uuid $debtorId): ?DebtorLimit;

    public function save(DebtorLimit $debtorLimit);
}