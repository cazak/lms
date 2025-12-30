<?php

declare(strict_types=1);

namespace App\Finance\SystemWallet\Command\Replenish;

final readonly class ReplenishSystemWalletCommandHandler
{
    public function __invoke(ReplenishSystemWalletCommand $command): void
    {
        $systemWallet = $this->repository->getSystemWallet();

        $systemWallet->increase($command->amount);

        $this->flusher->flush();
    }
}
