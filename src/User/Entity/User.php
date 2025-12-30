<?php

declare(strict_types=1);

namespace App\User\Entity;

use App\User\Entity\Type\EmailType;
use App\User\Entity\Type\IdType;
use App\User\Entity\Type\RoleType;
use App\User\Entity\Type\StatusType;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: 'user_users')]
#[ORM\HasLifecycleCallbacks]
final class User
{
    #[ORM\Id]
    #[ORM\Column(type: IdType::NAME)]
    private Id $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: EmailType::NAME, length: 255, unique: true)]
    private Email $email;

    #[ORM\Embedded(class: Token::class)]
    private ?Token $confirmationToken;

    #[ORM\Column(type: StatusType::NAME, length: 255)]
    private Status $status;

    #[ORM\Column(type: RoleType::NAME, length: 255)]
    private Role $role;

    /**
     * @var Collection<int, UserNetwork>
     */
    #[ORM\OneToMany(targetEntity: UserNetwork::class, mappedBy: 'user', cascade: ['all'], orphanRemoval: true)]
    private Collection $networks;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function __construct(
        Id $id,
        string $hashedPassword,
        Email $email,
        Token $confirmToken,
        DateTimeImmutable $createdAt,
    ) {
        $this->id = $id;
        $this->password = $hashedPassword;
        $this->email = $email;
        $this->confirmationToken = $confirmToken;
        $this->status = Status::wait();
        $this->role = Role::user();
        $this->createdAt = $createdAt;
        $this->updatedAt = clone $createdAt;
    }

    public function addNetwork(Network $network): void
    {
        foreach ($this->networks as $existing) {
            if ($existing->getNetwork()->isEqualTo($network)) {
                throw new DomainException('Network is already attached.');
            }
        }

        $this->networks->add(new UserNetwork($this, $network));
    }

    public function confirmSignup(string $token, DateTimeImmutable $date): void
    {
        if ($this->status->isConfirmed()) {
            throw new DomainException('User is already confirmed.');
        }

        $this->confirmationToken->validate($token, $date);
        $this->status = Status::confirmed();
        $this->confirmationToken = null;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getConfirmationToken(): ?Token
    {
        return $this->confirmationToken;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function isWait(): bool
    {
        return $this->status->isWait();
    }

    public function isConfirmed(): bool
    {
        return $this->status->isConfirmed();
    }

    #[ORM\PostLoad]
    public function checkEmbeds(): void
    {
        if ($this->confirmationToken) {
            if ($this->confirmationToken->isEmpty()) {
                $this->confirmationToken = null;
            }
        }
    }
}


/*
 * Create User:
 * 1. $user = new User($uuid, $username, $password, $email, $status, $createdAt)
 * 2. $user->confirmSignup();
 *
 * Reset password:
 * $user->requestPasswordReset($passwordResetToken);
 * $user->confirmPasswordReset($password);
 */
