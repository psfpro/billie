<?php

declare(strict_types=1);

namespace App\Company\Domain;

use Symfony\Component\Uid\Uuid;

final class Company
{
    private Uuid $id;
    private string $name;
    private CompanyType $type;
    private string $address;

    public function __construct(
        Uuid $id,
        string $name,
        CompanyType $type,
        string $address,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->address = $address;
    }

    public function updateDetails(
        string $name,
        CompanyType $type,
        string $address,
    ): void {
        $this->name = $name;
        $this->type = $type;
        $this->address = $address;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): CompanyType
    {
        return $this->type;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}