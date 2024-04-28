<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function dismissNotification(Request $req)
    {
        $notif = Notification::find($req->id);

        if ($notif->recipient_id == Auth::user()->id) {
            $notif->delete();
        }
    }
}
