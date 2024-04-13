<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Profile;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function generate(Request $request)
    {
        foreach (Profile::all() as $profile) {
            Recommendation::create(["user_1_id" => Auth::user()->id, "user_2_id" => $profile->user->id, "weight" => 1]);
        }
    }
}
