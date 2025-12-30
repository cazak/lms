<?php

declare(strict_types=1);

namespace App\Finance\Balance\Reserve\Command\Reserve;

final readonly class ReserveCommand
{
    public function __construct(
        public string $purchaseId,
        public string $ownerId,
        public string $buyerId,
        public string $amount
    ) {
    }
}
