<?php

declare(strict_types=1);

namespace App\Invoice\Application\Command\AddInvoice;

use App\Common\Bus\CommandHandler;
use App\Invoice\Domain\DebtorLimit\Repository\DebtorLimitRepositoryInterface;
use App\Invoice\Domain\Invoice\Invoice;
use App\Invoice\Domain\Invoice\Repository\InvoiceRepositoryInterface;

final readonly class AddInvoiceCommandHandler implements CommandHandler
{
    public function __construct(
        private DebtorLimitRepositoryInterface $debtorLimitRepository,
        private InvoiceRepositoryInterface $invoiceRepository,
    ) {
    }

    public function __invoke(AddInvoiceCommand $command): void
    {
        $limit = $this->debtorLimitRepository->findDebtorLimit($command->debtorId);
        if ($limit === null) {
            throw new \DomainException('Debtor limit not found');
        }

        $totalOpenInvoicesAmount =  $this->invoiceRepository->getTotalOpenInvoicesAmount($command->debtorId);
        $debtorLimit = $limit->getLimitAmount();

        if ($totalOpenInvoicesAmount + $command->amount > $debtorLimit) {
            throw new \DomainException('Debtor limit exceeded');
        }

        $invoice = new Invoice(
            $command->id,
            $command->debtorId,
            $command->creditorId,
            $command->amount,
            $command->issueDate,
            $command->dueDate,
        );

        $this->invoiceRepository->save($invoice);
    }
}