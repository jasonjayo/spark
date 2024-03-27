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
use App\Models\User;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        return view("search", [
            "profiles" => Profile::filter(request(['min_age', 'max_age']))->get(),
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


        $profile = Profile::create([
            'user_id' => 1, //fix this so its the actual id from the User model, how to access user model attributes tho? :(
            'gender' => $request->gender,
            'tagline' => $request->tagline,
            'bio' => $request->bio,
            'university' => $request->university,
            'work' => $request->work,
            'fav_movie' => $request->fav_movie,
            'fav_food' => $request->fav_food,
            'fav_song' => $request->fav_song,
            'personality_type' => $request->personality_type,
            'height' => $request->height,
            'languages' => $request->languages,
            'location' => $request->location,
        ]);



        return redirect(RouteServiceProvider::HOME);
    }
}



