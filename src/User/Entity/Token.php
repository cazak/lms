<?php

declare(strict_types=1);

namespace App\User\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use RuntimeException;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final readonly class Token
{
    /**
     * @var non-empty-string|null
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $value;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $expires;

    public function __construct(string $token, DateTimeImmutable $expires)
    {
        Assert::uuid($token);
        $this->value = mb_strtolower($token);

        $this->expires = $expires;
    }

    public function isExpired(DateTimeImmutable $expires): bool
    {
        return $this->expires <= $expires;
    }

    public function validate(string $token, DateTimeImmutable $expires): bool
    {
        $token = mb_strtolower($token);
        Assert::uuid($token);

        if ($this->value !== $token) {
            throw new DomainException('Token is invalid.');
        }

        if ($this->isExpired($expires)) {
            throw new DomainException('Token is expired.');
        }

        return true;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    /**
     * @return non-empty-string
     */
    public function getValue(): string
    {
        return $this->value ?? throw new RuntimeException('Token empty.');
    }

    public function getExpires(): DateTimeImmutable
    {
        return $this->expires ?? throw new RuntimeException('Empty empty.');
    }
}
