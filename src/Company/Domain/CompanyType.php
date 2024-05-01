<?php

declare(strict_types=1);

namespace App\Company\Domain;

enum CompanyType: string
{
    case Debtor = 'Debtor';
    case Creditor = 'Creditor';

    public function isDebtor(): bool
    {
        return $this === self::Debtor;
    }

    public function isCreditor(): bool
    {
        return $this === self::Creditor;
    }
}
