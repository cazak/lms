<?php

namespace App\Shared\Entity\ValueObject;

interface ValueObject
{
    public function isEqualTo(self $object): bool;
}
