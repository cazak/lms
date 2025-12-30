<?php

declare(strict_types=1);

namespace App\Course\Entity;

final class GainSkill
{
    private readonly Id $id;

    private string $name;

    private SkillType $type;
}
