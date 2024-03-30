<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Events\ChatSent;

use Pusher\Pusher;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("chat");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(["content" => "required|max:255", "recipient_id" => "numeric"]);

        $chat = new Chat;
        $chat->content = $request->content;
        $chat->sender_id = Auth::user()->id;
        $chat->recipient_id = $request->recipient_id;
        $chat->save();

        ChatSent::dispatch($chat);
        return response(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $messages = Chat::where(function ($query) use ($id) {
            $query->where("sender_id", "=", Auth::user()->id)->where("recipient_id", "=", $id);
        })->orWhere(function ($query) use ($id) {
            $query->where("sender_id", "=", $id)->where("recipient_id", "=", Auth::user()->id);
        })->get();
        return view("chat", [
            "messages" => $messages,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
