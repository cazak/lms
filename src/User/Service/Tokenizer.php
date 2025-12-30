<?php

declare(strict_types=1);

namespace App\User\Service;

use App\User\Entity\Token;
use DateInterval;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final readonly class Tokenizer
{
    public function __construct(private DateInterval $dateInterval)
    {
    }

    public function generate(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date->add($this->dateInterval),
        );
    }
}
