<?php

namespace App\Enums;

enum Seeking
{
    case SHORTTERM;
    case LONGTERM;
    case UNKNOWN;

    public function getLabel(): string
    {
        return match ($this) {
            self::SHORTTERM => "Short Term",
            self::LONGTERM => "Long Term",
            self::UNKNOWN => "Not sure",
        };
    }
}
