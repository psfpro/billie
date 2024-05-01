<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application;

use App\Invoice\Application\Command\AddInvoice\AddInvoiceCommand;
use App\Invoice\Application\Command\AddInvoice\AddInvoiceCommandHandler;
use App\Invoice\Domain\DebtorLimit\DebtorLimit;
use App\Invoice\Infrastructure\Persistence\Mock\DebtorLimitRepositoryMock;
use App\Invoice\Infrastructure\Persistence\Mock\InvoiceRepositoryMock;
use Codeception\Test\Unit;
use Symfony\Component\Uid\Uuid;

class AddInvoiceCommandHandlerTest extends Unit
{
    public function test()
    {
        $debtorLimit = new DebtorLimit(
            id: Uuid::fromString('00000000-0000-0000-0000-000000000004'),
            debtorId: Uuid::fromString('00000000-0000-0000-0000-000000000002'),
            limitAmount: 100,
            currentUtilizedAmount: 0,
        );
        $debtorLimitRepository = new DebtorLimitRepositoryMock($debtorLimit);
        $invoiceRepository = new InvoiceRepositoryMock();
        $handler = new AddInvoiceCommandHandler($debtorLimitRepository, $invoiceRepository);
        $command = new AddInvoiceCommand(
            id: Uuid::fromString('00000000-0000-0000-0000-000000000001'),
            debtorId: Uuid::fromString('00000000-0000-0000-0000-000000000002'),
            creditorId: Uuid::fromString('00000000-0000-0000-0000-000000000003'),
            amount: 1,
            issueDate: new \DateTimeImmutable('2021-01-01 00:00:00'),
            dueDate: new \DateTimeImmutable('2021-01-02 00:00:00'),
        );

        $handler($command);

        $result = $invoiceRepository->getSavedEntity();
        self::assertEquals([
            'id' => '00000000-0000-0000-0000-000000000001',
            'debtor_id' => '00000000-0000-0000-0000-000000000002',
            'creditor_id' => '00000000-0000-0000-0000-000000000003',
            'amount' => 1,
            'issue_date' => '2021-01-01 00:00:00',
            'due_date' => '2021-01-02 00:00:00',
        ], [
            'id' => $result->getId()->toRfc4122(),
            'debtor_id' => $result->getDebtorId()->toRfc4122(),
            'creditor_id' => $result->getCreditorId()->toRfc4122(),
            'amount' => $result->getAmount(),
            'issue_date' => $result->getIssueDate()->format('Y-m-d H:i:s'),
            'due_date' => $result->getDueDate()->format('Y-m-d H:i:s'),
        ]);
    }
}
