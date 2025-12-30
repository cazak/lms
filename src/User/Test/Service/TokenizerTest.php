<?php

declare(strict_types=1);

namespace App\User\Test\Service;

use App\User\Service\Tokenizer;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Tokenizer::class)]
final class TokenizerTest extends TestCase
{
    public function testCreate(): void
    {
        $dateInterval = new DateInterval('P1D');
        $date = new DateTimeImmutable('+1 day');
        $tokenizer = new Tokenizer($dateInterval);

        $token = $tokenizer->generate($date);

        self::assertEquals($date->add($dateInterval), $token->getExpires());
    }
}
