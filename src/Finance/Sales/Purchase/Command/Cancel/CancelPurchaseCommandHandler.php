<?php

declare(strict_types=1);

namespace App\Finance\Sales\Purchase\Command\Cancel;

final readonly class CancelPurchaseCommandHandler
{
    public function __invoke(CancelPurchaseCommand $command): void
    {
        $purchase = $this->repository->findActiveByCourseAndBuyer($command->courseId, $command->buyerId);

        $purchase->cancel();

        $this->flusher->flush();
    }
}
