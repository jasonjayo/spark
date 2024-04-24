<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "reported_id",
        "reporter_id",
        "reason",
        "status"
    ];

    public function reported(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'reported_id');
    }

    public function reporter(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'reporter_id');
    }

    public function getReportedName()
    {
        if ($this->reported) {
            return $this->reported->first_name . " " . $this->reported->second_name;
        }
        return "Deleted user";
    }

    public function getReporterName()
    {
        if ($this->reporter) {
            return $this->reporter->first_name . " " . $this->reporter->second_name;
        }
        return "Deleted user";
    }
}
