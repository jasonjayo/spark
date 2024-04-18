<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ban extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "user_id",
        "admin_id",
        "report_id",
        "reason",
        "active_from",
        "active_to"
    ];

    /**
     * Get the user associated with the Ban
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function admin(): HasOne
    {
        return $this->hasOne(User::class, "id", "admin_id");
    }
}
