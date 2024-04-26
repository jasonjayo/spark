<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Profile;
use App\Models\Recommendation;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function generate()
    {
        $my = Auth::user();
        $my_interests = collect($my->interests->pluck("id"));
        $my_traits = collect($my->traits->pluck("id"));
        foreach (Profile::all()->except(Auth::user()->id) as $profile) {

            $first_user_id = min($my->id, $profile->user->id);
            // $second_user_id = max($my->id, $profile->user->id);
            $second_user_id = $profile->user->id;

            if (!$my->reactionsSent->pluck("id")->contains($profile->user->id)) {

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
                    $weight += max([25 - $distance, -10]);
                }

                // common uni
                $weight += $my->profile->university === $profile->university ? 10 : 0;

                // common seeking
                $weight += $my->profile->seeking === $profile->seeking ? 15 : 0;
                // echo "Weight for " . $profile->user->first_name . " = " . $weight . "<br>";


                // Recommendation::updateOrCreate(
                //     [
                //         "user_1_id" => $first_user_id,
                //         "user_2_id" => $second_user_id
                //     ],
                //     ["weight" => $weight]
                // );
            } else {
                $weight = -9999;
            }

            if ($my->recommendations->contains($second_user_id)) {
                $my->recommendations()->updateExistingPivot($second_user_id, [
                    "weight" => $weight
                ]);
            } else {
                $my->recommendations()->attach($second_user_id, [
                    "weight" => $weight
                ]);
            }
        }
        return $my->recommendations()->where("weight", ">", 0)->simplePaginate(1);
    }

    public function index(Request $req)
    {
        return view("discovery", [
            "recommendations" => $this->generate()
        ]);
    }

    public function react(Request $req)
    {
        $my = Auth::user();

        $req->user()->reactionsSent()->attach($req->id, ["type" => $req->type]);

        if ($my->reactionsReceived->contains(User::find($req->id))) {
            $id = $req->id;
            $reactionReceived = $my->reactionsReceived->first(function ($user) use ($id) {
                return $user->id === intval($id);
            });
            if ($reactionReceived->pivot->type === "LIKE") {
                return redirect()->route("viewprofile", ["id" => $id])->with(["match" => true]);
            }
        }

        return redirect()->route("discovery")->with([
            "recommendations" => $this->generate()
        ]);
    }
}
