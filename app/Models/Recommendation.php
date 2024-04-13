<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = ["user_1_id", "user_2_id", "weight"];

    // +5 for each common interest
    // +10 for each common trait
    // +15 for each match in the compatibility report
    // For age: max(10 - (age2 - age1), -15)
    // For distance: max(25 - distance, -10)
    // +10 for same university
    // +15 for same seeking
}
