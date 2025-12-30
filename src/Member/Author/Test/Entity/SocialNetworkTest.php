<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity;

use InvalidArgumentException;

final class SocialNetworkTest
{
    public function testSuccess(): void
    {
        $network = new SocialNetwork(new AuthorBuilder()->build(), SocialNetwork::VK, 'nickname');

        self::assertEquals(SocialNetwork::VK, $network->getType());
    }

    public function testIncorrectNetwork(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new SocialNetwork(new AuthorBuilder()->build(), 'incorrect-network', 'nickname');
    }
}
