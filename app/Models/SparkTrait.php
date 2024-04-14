<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SparkTrait extends Model
{
    use HasFactory;

    protected $table = 'traits';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "trait_user", "user_id", "trait_id");
    }
}
