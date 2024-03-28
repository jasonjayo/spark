<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Enums\InterestedIn;
use App\Enums\Seeking;
use App\Enums\Gender;
use DateInterval;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = "user_id";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'gender',
        'seeeking',
        'interested_in',
        'tagline',
        'bio',
        'university',
        'work',
        'fav_movie',
        'fav_food',
        'fav_song',
        'personality_type',
        'height',
        'languages',
        'location',



    ];

    protected $casts = [
        "interested_in" => InterestedIn::class,
        "seeking" => Seeking::class,
        "gender" => Gender::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->join("users", "profiles.user_id", "=", "users.id");
        if (array_key_exists("min_age", $filters)) {
            $now = date_create("now");
            $max_dob = $now->sub(new DateInterval("P" . $filters["min_age"] . "Y"));
            $query->where("users.dob", "<=", $max_dob->format("Y-m-d"));
        }

        if (array_key_exists("max_age", $filters)) {
            $now = date_create("now");
            $min_dob = $now->sub(new DateInterval("P" . intval($filters["max_age"]) . "Y364D"));
            $query->where("users.dob", ">=", $min_dob->format("Y-m-d"));
        }

        if (array_key_exists("gender", $filters)) {
            $query->where("gender", "=", $filters["gender"]);
        }
    }

    public function isActive()
    {
        $duration = date_diff(date_create($this->last_active), date_create('now'));
        $total_mins = $this->getMinsFromDuration($duration);
        return $total_mins <= 10; // user is considered active if they've been online in last 10 mins
    }

    public function getLastActive()
    {
        $duration = date_diff(date_create($this->last_active), date_create('now'));
        $total_mins = $this->getMinsFromDuration($duration);
        if ($total_mins >= 1440) {
            $formatted_time = floor($total_mins / 60 / 24);
            return $formatted_time . (($formatted_time == 1) ? " day ago" : " days ago");
        } else if ($total_mins >= 60) {
            $formatted_time = floor($total_mins / 60);
            return $formatted_time . (($formatted_time == 1) ? " hour ago" : " hours ago");
        } else {
            return "{$total_mins} minutes ago";
        }
    }

    public function getAge()
    {
        return date_diff(date_create($this->user->dob), date_create('now'))->y;
    }

    private function getMinsFromDuration(DateInterval $duration)
    {
        return ($duration->y * 365.25 * 24 * 60) + ($duration->d * 24 * 60)
            + ($duration->h * 60) + $duration->i;
    }


}
