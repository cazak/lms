<?php

declare(strict_types=1);

namespace App\Finance\Balance\Entity\Balance;

use App\Balance\Entity\Balance\Id;
use App\Balance\Entity\Balance\Type;

interface Operation
{
    public function getId(): Id;

    public function getType(): Type;

    public function getDescription(): string;
}
