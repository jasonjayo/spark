<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Profile;
use App\Models\Photo;

class ProfileController extends Controller
{

    public function index(Request $request)
    {

        $errors = array();

        $min_age = $request->min_age;
        $max_age = $request->max_age;
        if (isset($min_age) && isset($max_age)) {
            if ($min_age > $max_age) {
                $request->merge(["min_age" => 18, "max_age" => 100]);
                array_push($errors, "Min age was greater than max, age filters reset.");
            }
        }

        $request->flash(); // allows use of old in search.blade.php

        $query = Profile::filter(request(['min_age', 'max_age', 'gender', 'online_now', 'interests', 'max_distance', 'query']));
        $sql = $query->toRawSQL();
        return view("search", [
            "profiles" => $query->get(),
            "sql" => $sql,
            "errors" => $errors
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function store(Request $request): RedirectResponse
    {
        if ($request->has('profile')) {

            $formFields = $request->validate([
                'gender' => "required|max:1",
                'tagline' => "nullable|max:50",
                'bio' => "required|max:1000",
                'university' => "nullable|max:50",
                'work' => "nullable|max:50",
                'interested_in' => 'required',
                'seeking' => 'required',
                'fav_movie' => "nullable|max:50",
                'fav_food' => "nullable|max:50",
                'fav_song' => "nullable|max:50",
                'personality_type' => "nullable|max:4",
                'height' => "nullable|numeric|decimal:0,2|max:9.99",
                'languages' => "nullable|max:50",
                'location' => "nullable|max:40",
            ]);

            // check if creating new profile or updating existing
            if (!isset(Auth::user()->profile)) {
                $formFields["user_id"] = Auth::user()->id;
                // new
                Profile::create($formFields);
            } else {
                // update
                Auth::user()->profile->update($formFields);
            }

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }

        if ($request->has('photo')) { {


                $request->validate([
                    'image' => 'required|mimes:jpg,png,jpeg|max:5048',
                    'photoName' => 'required'

                ]);

                $newImageName = time() . '-' . $request->photoName . '.' . $request->image->extension();

                $request->image->move(public_path('images/profilePhotos'), $newImageName);

                $photo = Photo::create([
                    'user_id' => $request->user()->id,
                    'photo_url' => $newImageName
                ]);


                return back()->with('status', "photo-saved");
            }
        }
    }

    public function show($id): View
    {
        $profile = Profile::findOrFail($id);
        return view('viewprofile', ['profile' => $profile]);
    }

    public function updateLocation(Request $request)
    {
        $user = Auth::user();
        $user->profile->location = $request->location;
        $user->profile->save();
        return response(null, 200);
    }
}
