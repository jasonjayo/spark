<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparkMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';
    public $timestamps = false;

    protected $fillable = [
        "user_1_id",
        "user_2_id",
    ];
}
