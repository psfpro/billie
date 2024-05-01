<?php

declare(strict_types=1);

namespace App\Invoice\Infrastructure\Persistence\Doctrine\Repository;

use App\Invoice\Domain\DebtorLimit\DebtorLimit;
use App\Invoice\Domain\DebtorLimit\Repository\DebtorLimitRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class DebtorLimitRepository implements DebtorLimitRepositoryInterface
{
    public function findDebtorLimit(Uuid $debtorId): ?DebtorLimit
    {
        // TODO: Implement findDebtorLimit() method.
    }

    public function save(DebtorLimit $debtorLimit)
    {
        // TODO: Implement save() method.
    }
}