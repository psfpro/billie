<?php

declare(strict_types=1);

namespace App\Invoice\Infrastructure\Api\Rest;

use App\Common\Bus\CommandBusInterface;
use App\Invoice\Application\Command\AddInvoice\AddInvoiceCommand;
use App\Invoice\Application\Command\MarkInvoicePaid\MarkInvoicePaidCommand;
use App\Invoice\Domain\Invoice\Repository\InvoiceRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InvoiceController extends AbstractController
{
    private readonly SerializerInterface $serializer;
    private readonly ValidatorInterface $validator;
    private readonly CommandBusInterface $commandBus;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        CommandBusInterface $commandBus,
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->commandBus = $commandBus;
    }

    #[Route('/invoices', methods: ['POST'])]
    public function addInvoice(Request $request, EntityManagerInterface $em): JsonResponse
    {
        /** @var InvoiceDTO $invoiceDTO */
        $invoiceDTO = $this->serializer->deserialize($request->getContent(), InvoiceDTO::class, 'json');
        $errors = $this->validator->validate($invoiceDTO);

        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }
        $invoiceId = Uuid::v7();
        $this->commandBus->dispatch(new AddInvoiceCommand(
            $invoiceId,
            $invoiceDTO->debtorId,
            $invoiceDTO->creditorId,
            $invoiceDTO->amount,
            $invoiceDTO->issueDate,
            $invoiceDTO->dueDate,
        ));

        return new JsonResponse(['invoiceId' => $invoiceId->toRfc4122(), 'status' => 'created'], 201);
    }

    #[Route('/invoices/{id}/mark-paid', methods: ['PATCH'])]
    public function markInvoicePaid(Uuid $id, InvoiceRepositoryInterface $repo, EntityManagerInterface $em): JsonResponse
    {
        $invoice = $repo->find($id);
        if (!$invoice) {
            return new JsonResponse(['error' => 'Invoice not found'], 404);
        }
        $this->commandBus->dispatch(new MarkInvoicePaidCommand($id));

        return new JsonResponse(['invoiceId' => $invoice->getId(), 'status' => 'paid']);
    }
}