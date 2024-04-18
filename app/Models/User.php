<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'second_name',
        'dob',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }

    public function traits(): BelongsToMany
    {
        return $this->belongsToMany(SparkTrait::class, "trait_user", "user_id", "trait_id");
    }

    public function recommendationsAsFirstUser()
    {
        return $this->belongsToMany(User::class, 'recommendations', 'user_1_id', 'user_2_id')->withPivot('weight');
    }

    public function recommendationsAsSecondUser()
    {
        return $this->belongsToMany(User::class, 'recommendations', 'user_2_id', 'user_1_id')->withPivot('weight');
    }

    public function recommendations()
    {
        // return $this->recommendationsAsFirstUser
        //     ->merge($this->recommendationsAsSecondUser)->sortByDesc(function ($recommendation) {
        //         return $recommendation->pivot->weight;
        //     });
        // $recommendationIds = Recommendation::where("user_1_id", "=", Auth::user()->id)->pluck("id");
        // return User::whereIn("id", $recommendationIds);
        return $this->belongsToMany(User::class, 'recommendations', 'user_1_id', 'user_2_id')
            ->withPivot('weight')
            ->orderBy("pivot_weight", "desc");
    }

    public function reactionsReceived()
    {
        return $this->belongsToMany(User::class, "reactions", "recipient_id", "sender_id")
            ->withPivot("type");
    }

    public function reactionsSent()
    {
        return $this->belongsToMany(User::class, "reactions", "sender_id", "recipient_id")
            ->withPivot("type");
    }

    public function isAdmin()
    {
        return Auth::user()->admin === 1;
    }
}
