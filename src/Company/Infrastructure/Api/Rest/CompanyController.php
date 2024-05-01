<?php

declare(strict_types=1);

namespace App\Company\Infrastructure\Api\Rest;

use App\Common\Bus\CommandBusInterface;
use App\Company\Application\Command\AddCompany\AddCompanyCommand;
use App\Company\Application\Command\UpdateCompany\UpdateCompanyCommand;
use App\Company\Domain\Company\Repository\CompanyRepositoryInterface;
use App\Company\Domain\CompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CompanyController extends AbstractController
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

    #[Route('/companies', methods: ['POST'])]
    public function addCompany(Request $request): JsonResponse
    {
        /** @var CompanyDTO $companyDTO */
        $companyDTO = $this->serializer->deserialize($request->getContent(), CompanyDTO::class, 'json');
        $errors = $this->validator->validate($companyDTO);

        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }
        $companyId = Uuid::v7();

        $this->commandBus->dispatch(new AddCompanyCommand(
            $companyId,
            $companyDTO->name,
            CompanyType::from($companyDTO->type),
            $companyDTO->address,
        ));

        return new JsonResponse(['companyId' => $companyId->toRfc4122(), 'status' => 'success'], 201);
    }

    #[Route('/companies/{id}', methods: ['PUT'])]
    public function updateCompany(
        Uuid $id,
        Request $request,
        CompanyRepositoryInterface $repo,
    ): JsonResponse {
        $company = $repo->find($id);
        if (!$company) {
            return new JsonResponse(['error' => 'Company not found'], 404);
        }
        /** @var CompanyDTO $companyDTO */
        $companyDTO = $this->serializer->deserialize($request->getContent(), CompanyDTO::class, 'json');
        $errors = $this->validator->validate($companyDTO);

        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }

        $this->commandBus->dispatch(new UpdateCompanyCommand(
            $id,
            $companyDTO->name,
            CompanyType::from($companyDTO->type),
            $companyDTO->address,
        ));

        return new JsonResponse(['status' => 'success']);
    }
}