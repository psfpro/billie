<?php

declare(strict_types=1);

namespace App\Invoice\Infrastructure\Persistence\Mock;

use App\Invoice\Domain\DebtorLimit\DebtorLimit;
use App\Invoice\Domain\DebtorLimit\Repository\DebtorLimitRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class DebtorLimitRepositoryMock implements DebtorLimitRepositoryInterface
{
    /** @var array<array-key, DebtorLimit> */
    private array $data;
    private ?DebtorLimit $savedEntity = null;

    public function __construct(...$debtorLimits)
    {
        $this->data = $debtorLimits;
    }

    public function findDebtorLimit(Uuid $debtorId): ?DebtorLimit
    {
        foreach ($this->data as $debtorLimit) {
            if ($debtorLimit->getDebtorId()->equals($debtorId)) {
                return $debtorLimit;
            }
        }

        return null;
    }

    public function save(DebtorLimit $debtorLimit)
    {
        $this->savedEntity = $debtorLimit;
        $this->data[] = $debtorLimit;
    }

    public function getSavedEntity(): DebtorLimit
    {
        $entity = $this->savedEntity;
        \assert($entity instanceof DebtorLimit);

        return $entity;
    }
}