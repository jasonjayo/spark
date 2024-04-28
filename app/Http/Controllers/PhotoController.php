<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class PhotoController extends Controller
{


    public function store(Request $request): RedirectResponse
    {

        $user = User::findOrFail($request->id);
        if (!Auth::user()->isAdmin() && $user->id != Auth::user()->id) {
            return redirect()->route("error")->with(["message" => "Not authorised.", "code" => 401]);
        }

        $request->validate([
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',
            'photoName' => 'required'
        ]);

        $newImageName = time() . '-' . $request->photoName . '.' . $request->image->extension();

        $request->image->move(public_path('images/profilePhotos'), $newImageName);

        $photo = Photo::create([
            'user_id' => $user->id,
            'photo_url' => $newImageName,
            'name' => $request->photoName
        ]);


        return back()->with('status', "photo-saved");
    }

    public function destroy(Request $request): RedirectResponse
    {
        $imageName = $request->photoUrl;
        $path = public_path('images/profilePhotos/' . $imageName);
        if (file_exists($path)) {
            File::delete($path);
        }

        $photoId = $request->photoId;
        DB::table('photos')->where('id', $photoId)->delete();

        return back()->with('status', "photo-deleted");
    }
}
