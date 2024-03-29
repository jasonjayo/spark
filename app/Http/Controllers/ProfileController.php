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
        $request->flash(); // allows use of old in search.blade.php
        $query = Profile::filter(request(['min_age', 'max_age', 'gender', 'online_now', 'interests']));
        $sql = $query->toRawSQL();
        return view("search", [
            "profiles" => $query->get(),
            "sql" => $sql
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

        $formFields = $request->validate([
            'gender' => "required|max:1",
            'tagline' => "nullable|max:50",
            'bio' => "required|max:1000",
            'university' => "nullable|max:50",
            'work' => "nullable|max:50",
            'fav_movie' => "nullable|max:50",
            'fav_food' => "nullable|max:50",
            'fav_song' => "nullable|max:50",
            'personality_type' => "nullable|max:4",
            'height' => "nullable|numeric|max:50",
            'languages' => "nullable|max:50",
            'location' => "nullable|max:30",
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
}
