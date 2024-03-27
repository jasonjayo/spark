<?php


namespace App\Enums;

enum Gender: string
{
    case MALE = "m";
    case FEMALE = "f";
    case PREF_NOT_SAY = "o";
    case OTHER = "x";

    public function getLabel(): string {
        return match ($this) {
            self::MALE => "Male",
            self::FEMALE => "Female",
            self::PREF_NOT_SAY => "Prefer not to say",
            self::OTHER => "Other",
        };
    }
}
