<?php

declare(strict_types=1);

namespace App\Finance\Sales\Refund\Entity;

final readonly class Refund
{
    public function __construct(
        Id $id,
        PurchaseId $purchaseId,

    ) {
        $this->recordEvent(new RefundEvent());
    }
}
