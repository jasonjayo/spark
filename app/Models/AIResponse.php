<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIResponse extends Model
{
    use HasFactory;

    protected $table = "ai_responses";
    public $timestamps = false;

    protected $fillable = [
        "user_1_id",
        "user_2_id",
        "content"
    ];
}
