<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateOfBirth implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $today = date('Y/m/d');
        $currentDate = strtotime($today);
        $usersDob = strtotime($value);
        $diff = abs($currentDate - $usersDob);
        $years = floor($diff / (365 * 60 * 60 * 24));
        if ($years < 18) {
            $fail('You must be over 18 to join Spark');
        }
    }
}
