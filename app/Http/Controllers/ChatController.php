<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Events\ChatSent;
use App\Models\AIResponse;
use App\Models\User;
use Exception;
use Pusher\Pusher;

use Orhanerday\OpenAi\OpenAi;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("chat-index");
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
        try {
            $other_user = User::findOrFail(request()->id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route("error")->with(["message" => "User with ID '" . request()->id . "' doesn't exist.", "code" => 404]);
        }

        $messages = Auth::user()->getMessagesWith(intval($id));
        return view("chat", [
            "messages" => $messages,
            "other_user" => $other_user
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

    public function getAISuggestions(string $id)
    {
        $open_ai_key = env('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);

        $my = Auth::user();

        $my_interests = $my->interests->map(
            fn ($item) => $item->name
        )->join(", ");
        $other_interests = User::find($id)->interests->map(
            fn ($item) => $item->name
        )->join(", ");

        $prompt = "I am interested in " . $my_interests . ".
        The person I'm chatting with is interested in " . $other_interests . ".
        I speak " . $my->profile->languages . " and they speak " . User::find($id)->profile->languages . ".
        Suggest 3 date ideas for us. Give a very short description of each.
        For each, include an emoji.
        Format the list like this example:
        <ol class='list-group list-group-numbered'>
          <li class='list-group-item'><strong>Go for a swim:</strong>description</li>
        </ol>";


        $chat = $open_ai->chat([
            'model' => 'gpt-3.5-turbo-0125',
            'messages' => [
                [
                    "role" => "system",
                    "content" => "You are an assistant in a dating app."
                ],
                [
                    "role" => "user",
                    "content" => $prompt
                ],
            ],
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        $d = json_decode($chat);
        try {
            $content = $d->choices[0]->message->content;
        } catch (Exception $e) {
            return back()->with(["generation_error" => true]);
        }

        $first_user_id = min($my->id, $id);
        $second_user_id = max($my->id, $id);

        AIResponse::updateOrCreate([
            "user_1_id" => $first_user_id,
            "user_2_id" => $second_user_id
        ], [
            "content" => $content
        ]);

        return back()->withFragment('#date-ideas');
    }
}
