<?php

declare(strict_types=1);

namespace App\User\Command\Register\Confirm;

use App\Shared\Service\Flusher;
use App\User\Entity\UserRepository;
use DateTimeImmutable;

final readonly class Handler
{
    public function __construct(
        private UserRepository $userRepository,
        private Flusher $flusher,
    ) {
    }

    public function __invoke(Command $command): void
    {
        $user = $this->userRepository->getByJoinConfirmationToken($command->token);

        $user->confirmSignup($command->token, new DateTimeImmutable());

        $this->flusher->flush();
    }
}
