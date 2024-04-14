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
        $my = Auth::user();
        $my_interests = collect($my->interests->pluck("id"));
        $my_traits = collect($my->traits->pluck("id"));
        foreach (Profile::all()->except(Auth::user()->id) as $profile) {

            $weight = 0;

            // common interests +5
            $other_interests = collect($profile->user->interests->pluck("id"));
            $weight += count($my_interests->intersect($other_interests)) * 5;

            // common traits +10
            $other_traits = collect($profile->user->traits->pluck("id"));
            $weight += count($my_traits->intersect($other_traits)) * 10;

            // TODO +15 for each match in the compatibility report (special traits e.g., night owl)

            // age max(10 - (age2 - age1), -15)
            $weight += max([10 - (abs($my->profile->getAge() - $profile->getAge())), -15]);

            // distance max(25 - distance, -10)
            $distance = $profile->getNumericalDistance();
            if ($distance !== null) {
                $weight += max([25 - $distance, -15]);
            }

            // common uni
            $weight += $my->profile->university === $profile->university ? 10 : 0;

            // common seeking
            $weight += $my->profile->seeking === $profile->seeking ? 15 : 0;
            echo "Weight for " . $profile->user->first_name . " = " . $weight . "<br>";

            $first_user_id = min($my->id, $profile->user->id);
            $second_user_id = max($my->id, $profile->user->id);

            // Recommendation::updateOrCreate(
            //     [
            //         "user_1_id" => $first_user_id,
            //         "user_2_id" => $second_user_id
            //     ],
            //     ["weight" => $weight]
            // );

            $profile->user->recommendations()->attach($my, ['weight' => $weight]);
        }
    }

    public function index(Request $req)
    {
        $id = Auth::user()->id;
        // $recommendations = Recommendation::where("user_1_id", "=", $id)->orWhere("user_2_id", "=", $id)->get();
        $recommendations = $req->user()->recommendations();

        return view("discovery", [
            "recommendations" => $recommendations
        ]);
    }
}
