<?php

namespace App\Enums;

enum Difficulty: int
{
    case Easy = 1;
    case Medium = 2;
    case Hard = 3;
    case Expert = 4;
    case Legendary = 5;

    public function xp(): int
    {
        return $this->value * 10;
    }
}