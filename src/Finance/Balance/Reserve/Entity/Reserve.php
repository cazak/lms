<?php

declare(strict_types=1);

namespace App\Finance\Balance\Reserve\Entity;

final class Reserve
{
    private readonly Id $id;

    private readonly PurchaseId $purchaseId;

    private readonly OwnerId $ownerId;

    private readonly BuyerId $buyerId;

    private Money $money;

    private Money $commission;

    private Status $status;

    private readonly DateTimeImmutable $createdAt;

    private readonly DateTimeImmutable $expiredAt;

    public function __construct(
        Id $id,
        PurchaseId $purchaseId,
        OwnerId $ownerId,
        BuyerId $buyerId,
        Money $money,
        int $commissionPercent,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
        DateTimeImmutable $expiredAt = new DateTimeImmutable(),
    ) {
        $this->id = $id;
        $this->purchaseId = $purchaseId;
        $this->ownerId = $ownerId;
        $this->buyerId = $buyerId;
        $this->money = $money;
        $this->commission = $this->calculateCommission($money, $commissionPercent);
        $this->createdAt = $createdAt;
        $this->expiredAt = $expiredAt;
    }

    private function calculateCommission(Money $money, int $commissionPercent): Money
    {
        return $money->multiply($commissionPercent / 100);
    }

    public function getAmount(): Money
    {
        return $this->money->multiply($this->commission);
    }
}
