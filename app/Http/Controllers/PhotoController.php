<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Redirect;

class PhotoController extends Controller
{


    public function store(Request $request): RedirectResponse
    {


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
        ;
    }


}