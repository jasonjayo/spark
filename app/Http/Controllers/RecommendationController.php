<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Enums\InterestedIn;
use App\Models\AIResponse;
use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Profile;
use App\Models\Recommendation;
use App\Models\SparkMatch;
use App\Models\User;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function generate()
    {
        $my = Auth::user();
        $my_interests = collect($my->interests->pluck("id"));
        $my_traits = collect($my->traits->pluck("id"));
        foreach (Profile::all()->except(Auth::user()->id) as $profile) {

            // reset any previous recommendation of this user first
            $my->recommendations()->detach($profile->user->id);

            if (
                $my->profile->interested_in === InterestedIn::MEN && !in_array($profile->gender, [Gender::MALE, Gender::PREF_NOT_SAY]) ||
                $my->profile->interested_in === InterestedIn::WOMEN && !in_array($profile->gender, [Gender::FEMALE, Gender::PREF_NOT_SAY]) ||
                $profile->interested_in === InterestedIn::MEN && !in_array($my->profile->gender, [Gender::MALE, Gender::PREF_NOT_SAY]) ||
                $profile->interested_in === InterestedIn::WOMEN && !in_array($my->profile->gender, [Gender::FEMALE, Gender::PREF_NOT_SAY])
            ) {
                continue;
            }

            $second_user_id = $profile->user->id;

            if (!$my->reactionsSent->pluck("id")->contains($profile->user->id)) {

                $weight = 0;

                // common interests +5
                $other_interests = collect($profile->user->interests->pluck("id"));
                $weight += count($my_interests->intersect($other_interests)) * 5;

                // common traits +10
                $other_traits = collect($profile->user->traits->pluck("id"));
                $weight += count($my_traits->intersect($other_traits)) * 10;

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

            } else {
                $weight = -9999;
            }

            $my->recommendations()->attach($second_user_id, [
                "weight" => $weight
            ]);
        }
        return $my->recommendations()->where("weight", ">", 0)->orderBy('weight', 'desc')->simplePaginate(1);
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
                // match
                $user_1_id = min($my->id, $id);
                $user_2_id = max($my->id, $id);
                SparkMatch::updateOrCreate(["user_1_id" => $user_1_id, "user_2_id" => $user_2_id]);

                // send notification to other user
                Notification::create([
                    "recipient_id" => $id,
                    "title" => "New Match!",
                    "contents" => "🎉 It's a match! You can now chat with " . $my->first_name . ".",
                    "link" => "/viewprofile/" . $my->id
                ]);
                return redirect()->route("viewprofile", ["id" => $id])->with(["match" => true]);
            }
        }

        return back()->with([
            "recommendations" => $this->generate()
        ]);
    }

    public function deleteMatch(Request $req)
    {
        $my = Auth::user();
        $id = $req->id;

        $user_1_id = min($my->id, $id);
        $user_2_id = max($my->id, $id);

        // remove match
        SparkMatch::where(["user_1_id" => $user_1_id, "user_2_id" => $user_2_id])->first()->delete();
        // remove unmatching user's reaction
        $req->user()->reactionsSent()->detach($req->id);
        // remove ai date suggestions if exists

        $ai_response = AIResponse::where('user_1_id', $user_1_id)->where('user_2_id', $user_2_id)->first();
        if ($ai_response) {
            $ai_response->delete();
        }

        return back();
    }
}
