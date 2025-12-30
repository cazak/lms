<?php

declare(strict_types=1);

namespace App\Finance\Sales\Purchase\Entity;

use App\Finance\Sales\Purchase\Entity\Event\PurchaseCreatedEvent;
use App\Sales\Entity\BuyerId;
use App\Sales\Entity\CourseId;
use App\Sales\Entity\Id;
use App\Sales\Entity\SellerId;
use App\Sales\Entity\Status;
use App\Sales\Purchase\Entity\Money;
use DateTimeImmutable;

final class Purchase
{
    private readonly Id $id;

    private readonly BuyerId $buyerId;

    private readonly SellerId $sellerId;

    private readonly CourseId $courseId;

    private readonly Money $price;

    private Status $status;

    private readonly DateTimeImmutable $createdAt;

    public function __construct(
        Id $id,
        BuyerId $buyerId,
        SellerId $sellerId,
        CourseId $courseId,
        Money $price,
    ) {
        $this->id = $id;
        $this->buyerId = $buyerId;
        $this->sellerId = $sellerId;
        $this->courseId = $courseId;
        $this->price = $price;
        $this->status = Status::new();
        $this->createdAt = new DateTimeImmutable();

        $this->recordEvent(new PurchaseCreatedEvent(
            $this->id,
            $this->courseId,
            $this->buyerId,
        ));
    }
}
