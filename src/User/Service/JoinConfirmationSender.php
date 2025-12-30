<?php

declare(strict_types=1);

namespace App\User\Service;

use App\User\Entity\Email;
use App\User\Entity\Token;

final readonly class JoinConfirmationSender
{
    public function send(Email $email, Token $token): void
    {
    }
}
