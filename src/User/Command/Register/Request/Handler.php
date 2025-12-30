<?php

declare(strict_types=1);

namespace App\User\Command\Register\Request;

use App\Shared\Service\Flusher;
use App\User\Entity\Email;
use App\User\Entity\Id;
use App\User\Entity\User;
use App\User\Entity\UserRepository;
use App\User\Service\JoinConfirmationSender;
use App\User\Service\PasswordHasher;
use App\User\Service\Tokenizer;
use DateTimeImmutable;
use DomainException;

final readonly class Handler
{
    public function __construct(
        private UserRepository $userRepository,
        private Tokenizer $tokenizer,
        private PasswordHasher $passwordHasher,
        private JoinConfirmationSender $joinConfirmationSender,
        private Flusher $flusher,
    ) {
    }

    public function __invoke(Command $command): void
    {
        $email = new Email($command->email);
        $token = $this->tokenizer->generate(new DateTimeImmutable());

        if ($this->userRepository->hasByEmail($email)) {
            throw new DomainException('User with this email already exists.');
        }

        $user = new User(
            Id::generate(),
            $this->passwordHasher->hash($command->password),
            $email,
            $token,
            new DateTimeImmutable(),
        );

        $this->userRepository->add($user);
        $this->flusher->flush();

        $this->joinConfirmationSender->send($email, $token);
    }
}
