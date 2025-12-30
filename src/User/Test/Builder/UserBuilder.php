<?php

declare(strict_types=1);

namespace App\User\Test\Builder;

use App\User\Entity\Email;
use App\User\Entity\Id;
use App\User\Entity\Token;
use App\User\Entity\User;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final class UserBuilder
{
    private Id $id;
    private Email $email;
    private string $password;
    private Token $confirmationToken;
    private DateTimeImmutable $createdAt;
    private bool $isActive;

    public function __construct(
    ) {
        $this->id = Id::generate();
        $this->email = new Email('test@test.com');
        $this->password = 'password';
        $this->confirmationToken = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable('+1 day'));
        $this->createdAt = new DateTimeImmutable();
        $this->isActive = false;
    }

    public function confirmed(): self
    {
        $user = clone $this;
        $user->isActive = true;

        return $user;
    }

    public function withConfirmationToken(?Token $token): self
    {
        $user = clone $this;
        $user->confirmationToken = $token;

        return $user;
    }

    public function build(): User
    {
        $user = new User(
            $this->id,
            $this->password,
            $this->email,
            $this->confirmationToken,
            $this->createdAt,
        );

        if ($this->isActive) {
            $user->confirmSignup(
                $this->confirmationToken->getValue(),
                $this->confirmationToken->getExpires()->modify('-1 day'),
            );
        }

        return $user;
    }
}
