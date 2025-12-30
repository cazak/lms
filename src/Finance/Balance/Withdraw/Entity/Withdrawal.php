<?php

declare(strict_types=1);

namespace App\Finance\Balance\Withdraw\Entity;

use App\Balance\Withdraw\Entity\Id;
use App\Balance\Withdraw\Entity\Type;
use App\Finance\Balance\Entity\Balance\Operation;
use App\Finance\Balance\Entity\Balance\Transaction;

final readonly class Withdrawal implements Operation
{
    private Id $id;

    private Transaction $transaction;

    public function getId(): Id
    {
        // TODO: Implement getId() method.
    }

    public function getType(): string|Type
    {
        // TODO: Implement getType() method.
    }

    public function getDescription(): string
    {
        // TODO: Implement getDescription() method.
    }
}
