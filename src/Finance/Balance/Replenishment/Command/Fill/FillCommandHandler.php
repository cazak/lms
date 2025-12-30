<?php

declare(strict_types=1);

namespace App\Finance\Balance\Replenishment\Command\Fill;

use App\Balance\Command\Fill\Money;
use App\Balance\Replenishment\Command\Fill\BalanceId;
use App\Balance\Replenishment\Command\Fill\Id;
use App\Balance\Replenishment\Command\Fill\Replenishment;
use App\Balance\Replenishment\Command\Fill\TransactionType;
use App\Finance\Balance\Entity\Balance\Transaction;

final readonly class FillCommandHandler
{
    public function __invoke(FillCommand $command): void
    {
        $money = Money::usd($command->amount);

        $balance = $this->repository->findBalanceByOwnerId($command->ownerId);

        $balance->increase($money);
        $transaction = new Transaction(
            Id::next(),
            new BalanceId($balance->getId()),
            new Replenishment(),
            TransactionType::REPLENISHMENT,
            $money
        );

        $this->repository->add($transaction);
        $this->flusher->flush();
    }
}
