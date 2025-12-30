<?php

declare(strict_types=1);

namespace App\Finance\Balance\Reserve\Command\Cancel;

final readonly class CancelReserveCommandHandler
{
    public function __invoke(CancelReserveCommand $command): void
    {
        $reserve = $this->reserveRepository->findById($command->reserveId);
        $buyer = $this->balanceRepository->findById($reserve->getBuyerId());

        $transaction = $buyer->increase(
            $reserve->getAmount(),
            new TransactionSource($command->refundId, TransactionSource::REFUND)
        );

        $reserve->cancel(); // Exception если уже или expired

        $this->repo->save($transaction);
        $this->flusher->flush();
    }
}
