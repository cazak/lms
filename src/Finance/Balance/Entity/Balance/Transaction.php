<?php

declare(strict_types=1);

namespace App\Finance\Balance\Entity\Balance;

use App\Balance\Entity\BalanceId;
use App\Balance\Entity\Id;
use App\Balance\Entity\Money;
use App\Finance\Balance\Entity\Balance\ValueObject\TransactionSource;
use DateTimeImmutable;

final readonly class Transaction // History
{
    private Id $id;

    private BalanceId $balanceId;

    private TransactionSource $source;

    private Money $amount;

    private DateTimeImmutable $createdAt;

    public function __construct(
        Id $id,
        BalanceId $balanceId,
        TransactionSource $source,
        Money $amount
    ) {
        $this->id = $id;
        $this->balanceId = $balanceId;
        $this->source = $source;
        $this->amount = $amount;
        $this->createdAt = new DateTimeImmutable();
    }
}
