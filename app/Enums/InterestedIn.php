<?php

namespace App\Enums;

enum InterestedIn
{
    case MEN; // could use case MEN = 'Men' here if needed
    case WOMEN;
    case ALL;

    public function getLabel(): string
    {
        return match ($this) {
            self::WOMEN => "Women",
            self::MEN => "Men",
            self::ALL => "All",
        };
    }
}
