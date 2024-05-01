<?php

declare(strict_types=1);

namespace App\Company\Application\Command\AddCompany;

use App\Company\Domain\CompanyType;
use Symfony\Component\Uid\Uuid;

final class AddCompanyCommand
{
    public function __construct(
        public Uuid $id,
        public string $name,
        public CompanyType $type,
        public string $address,
    ) {
    }
}