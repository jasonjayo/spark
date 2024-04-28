<?php

namespace App\Models;

use App\Events\NotificationSent;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Notification extends Model
{
    use BroadcastsEvents, HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "recipient_id",
        "contents",
        "title",
        "link"
    ];

    public function recipient(): HasOne
    {
        return $this->hasOne(User::class, "id", "recipient_id");
    }

    protected static function booted(): void
    {
        static::created(function (Notification $notif) {
            NotificationSent::dispatch($notif);
        });
    }
}
