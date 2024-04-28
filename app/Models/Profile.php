<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        'seeking',
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

        if (array_key_exists("max_distance", $filters) && $filters["max_distance"] < 100) {
            $coords = explode(",", Auth::user()->profile->location);
            $lat = floatval($coords[0]);
            $long = floatval($coords[1]);

            $query->select("*")->from(DB::raw("(select user_id,
            ST_Distance_Sphere(
                POINT(?, ?),
                POINT(
                    SUBSTRING_INDEX(location, ',', 1),
                    SUBSTRING_INDEX(location, ',', -1)
                )
            ) / 1000 AS distance
            FROM profiles) distances natural join profiles"), []);

            $query->setBindings([$lat, $long]);

            $query->where("distance", "<", $filters["max_distance"]);
        }

        if (array_key_exists("min_age", $filters)) {
            $now = date_create("now");
            $max_dob = $now->sub(new DateInterval("P" . $filters["min_age"] . "Y"));
            $query->where("users.dob", "<=", $max_dob->format("Y-m-d"));
        }

        if (array_key_exists("max_age", $filters)) {
            $now = date_create("now");
            $min_dob = $now->sub(new DateInterval("P" . $filters["max_age"] . "Y364D"));
            $query->where("users.dob", ">=", $min_dob->format("Y-m-d"));
        }

        if (array_key_exists("gender", $filters)) {
            if ($filters["gender"] != "all") {
                $query->where("gender", "=", $filters["gender"]);
            }
        }

        if (array_key_exists("online_now", $filters) && $filters["online_now"] == "yes") {
            $now = date_create("now");
            $ten_mins_ago = $now->sub(new DateInterval("PT10M"));
            $query->where("last_active", ">=", $ten_mins_ago->format("Y-m-d H:i:s"));
        }

        if (array_key_exists("interests", $filters) && $filters["interests"] != "") {
            // first get users who have at least 1 of the interests from filters
            // then get users from main query who also appear in this result
            $users_with_interest = DB::table("interest_user")->select("user_id")->whereIn("interest_id", array_filter(explode(",", $filters["interests"])));
            $query->whereIn("users.id", $users_with_interest);
        }

        if (array_key_exists("query", $filters) && $filters["query"] != "") {
            $query->where("first_name", "LIKE", "%" . $filters["query"] . "%");
            $query->orWhere("second_name", "LIKE", "%" . $filters["query"] . "%");
            $query->orWhere("tagline", "LIKE", "%" . $filters["query"] . "%");
        }

        $query->where("id", "!=", Auth::user()->id);
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

    /**
     * returns rounded up distance to this user in km or null if either user has no location set
     * @return int|null
     * @
     */
    public function getNumericalDistance()
    {
        if (isset(Auth::user()->profile->location) && isset($this->location)) {
            $other_user_lat_long = explode(',', $this->location);
            $current_user_lat_long = explode(',', Auth::user()->profile->location);
            if (count($current_user_lat_long) == 2 && count($other_user_lat_long) == 2) {
                // using DB ST_Distance_Sphere here so distance calculations are consistent
                $res = DB::select(
                    "select ST_Distance_Sphere(POINT(?, ?), POINT(?, ?)) / 1000 AS distance",
                    [$current_user_lat_long[0], $current_user_lat_long[1], $other_user_lat_long[0], $other_user_lat_long[1]]
                );
                return ceil($res[0]->distance);
            }
            return null;
        }
        return null;
    }

    /**
     * returns distance string in format "About x km away" or null if no distance available
     * @return string|null
     */
    public function getDistance()
    {
        $numerical_distance = $this->getNumericalDistance();
        if ($numerical_distance !== null) {

            return "About " . $numerical_distance . " km away";
        }
        return null;
    }

    private function getMinsFromDuration(DateInterval $duration)
    {
        return ($duration->y * 365.25 * 24 * 60) + ($duration->d * 24 * 60)
            + ($duration->h * 60) + $duration->i;
    }

    public function getMatches()
    {
        SparkMatch::where("user_1_id", "=", Auth::user()->id)
            ->orWhere("user_2_id", "=", Auth::user()->id);
    }
}
