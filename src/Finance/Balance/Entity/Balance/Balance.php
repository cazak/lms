<?php

declare(strict_types=1);

namespace App\Finance\Balance\Entity\Balance;

use App\Balance\Entity\Balance\BalanceId;
use App\Balance\Entity\Balance\IncufficentFundsException;
use App\Balance\Entity\Balance\TransactionSource;
use App\Balance\Entity\Collection;
use App\Balance\Entity\Id;
use App\Balance\Entity\Money;
use App\Balance\Entity\OwnerId;

final class Balance
{
    private readonly Id $id;

    private readonly OwnerId $ownerId;

//    /**
//     * @var Collection<int, Transaction>
//     */
//    private Collection $transactions;

    private Money $balance; // Валюта только рубли

    public function __construct(Id $id, OwnerId $ownerId, Money $balance)
    {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->balance = $balance;
    }

    public function increase(Money $amount, TransactionSource $source): Transaction
    {
        $this->balance->increase($amount);

        return new Transaction(
            Id::next(),
            new BalanceId($this->id),
            $source,
            $amount,
        );
    }

    public function decrease(Money $amount, TransactionSource $source): Transaction
    {
        if (!$this->balance->greaterThan($amount)) {
            throw new IncufficentFundsException();
        }

        $this->balance = $this->balance->subtract($amount);

        return new Transaction(
            Id::next(),
            new BalanceId($this->id),
            $source,
            $amount,
        );
    }
}
