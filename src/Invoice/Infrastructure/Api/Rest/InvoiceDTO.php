<?php

declare(strict_types=1);

namespace App\Invoice\Infrastructure\Api\Rest;

use Symfony\Component\Uid\Uuid;

final class InvoiceDTO
{
    public Uuid $debtorId;
    public Uuid $creditorId;
    public int $amount;
    public \DateTimeImmutable $issueDate;
    public \DateTimeImmutable $dueDate;
}