<?php

declare(strict_types=1);

namespace App\Finance\Balance\Reserve\Command\Complete;

final readonly class CompleteReserveCommandHandler
{
    public function __invoke(CompleteReserveCommand $command): void
    {
        $reserve = $this->reserveRepository->findById($command->reserveId);
        $authorBalance = $this->balanceRepository->findById($reserve->getOwnerId());

        $transaction = $authorBalance->increase(
            $reserve->getAmount(),
            new TransactionSource($reserve->getPurchaseId(), TransactionSource::SALE)
        );

        $reserve->complete();

        $command = new ReplinishSystemWallet(
            $reserve->getCommissionAmount(),
        );
        ($this->commandHandler)($command);

        $this->repo->save($transaction);
        $this->flusher->flush();
    }
}
