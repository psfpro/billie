<?php

declare(strict_types=1);

namespace App\Invoice\Application\Command\AddInvoice;

use Symfony\Component\Uid\Uuid;

final class AddInvoiceCommand
{
    public function __construct(
        public Uuid $id,
        public Uuid $debtorId,
        public Uuid $creditorId,
        public int $amount,
        public \DateTimeImmutable $issueDate,
        public \DateTimeImmutable $dueDate,
    ) {
    }
}