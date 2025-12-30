<?php

declare(strict_types=1);

namespace App\Finance\Balance\Entity\Balance\ValueObject;

use App\Balance\Entity\Balance\ValueObject\Assert;
use App\Shared\Entity\ValueObject\ValueObject;

final readonly class TransactionSource implements ValueObject
{
    private const string REPLENISHMENT = 'replenishment';
    private const string WITHDRAWAL = 'withdrawal';
    private const string PURCHASE = 'purchase';
    private const string SALE = 'sale';

    private string $id;
    private string $type;

    private function __construct(string $type, string $id)
    {
        Assert::oneOf($type, [
            self::REPLENISHMENT,
            self::WITHDRAWAL,
            self::PURCHASE,
            self::SALE,
        ]);

        $this->type = $type;
        $this->id = $id;
    }

    public static function replenishment(string $id): self
    {
        return new self(self::REPLENISHMENT, $id);
    }

    public function isReplenishment(): bool
    {
        return $this->type === self::REPLENISHMENT;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param TransactionSource $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->type === $object->getType() && $this->id === $object->id;
    }
}
