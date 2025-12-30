<?php

declare(strict_types=1);

namespace App\Finance\Balance\Reserve\Command\Reserve;

use App\Finance\Balance\Reserve\Command\Id;
use App\Finance\Balance\Reserve\Command\ReserveRepository;
use App\Finance\Balance\Reserve\Entity\Reserve;

final readonly class ReserveCommandHandler
{
    public function __construct(
        private ReserveRepository $reserveRepository,
        private int $commissionPercent
    ) {
    }

    public function __invoke(ReserveCommand $command): void
    {
        $buyerBalance = $this->balanceRepository->findById($command->buyerId);
        $reserve = new Reserve(
            Id::generate(),
            $command->purchaseId,
            $command->ownerId,
            $command->buyerId,
            $command->amount,
            $this->commissionPercent
        );

        $transaction = $buyerBalance->decrease(
            $command->amount,
            new TransactionSource($command->purchaseId, TransactionSource::PURCHASE)
        );

        $this->balanceRepository->save($transaction);
        $this->reserveRepository->save($reserve);
    }
}
