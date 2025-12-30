<?php

declare(strict_types=1);

namespace App\Finance\Sales\Purchase\Query\GetBalance;

final readonly class GetBalanceQueryHandler
{
    public function __invoke(GetBalanceQuery $query)
    {
        return $this->findBalanceByAccountId($query->accountId);
    }
}
