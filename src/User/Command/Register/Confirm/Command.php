<?php

declare(strict_types=1);

namespace App\User\Command\Register\Confirm;
final readonly class Command
{
    public function __construct(
        public string $token,
    ) {
    }
}
