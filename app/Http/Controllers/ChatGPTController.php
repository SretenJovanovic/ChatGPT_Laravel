<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;

class ChatGPTController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('chatgpt.index', [
            'user' => $user
        ]);
    }

    public function ask(Request $request)
    {

        $search = $request->input('prompt');

        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])
            ->post("https://api.openai.com/v1/chat/completions", [
                "model" => "gpt-3.5-turbo",
                'messages' => [
                    [
                        "role" => "user",
                        "content" => $search
                    ]
                ],
                'temperature' => 0.5,
                "max_tokens" => 200,
                "top_p" => 1.0,
                "frequency_penalty" => 0.52,
                "presence_penalty" => 0.5,
                "stop" => ["1."],
            ])
            ->json();

        return view('chatgpt.response', ['response' => $data['choices'][0]['message']['content']]);
    }
    // public function ask(Request $request)
    // {
    //     $prompt = $request->input('prompt');

    //     $response = OpenAI::completions()->create([
    //         'model' => 'text-davinci-003',
    //         'prompt' => $prompt,
    //         'temperature' => 1,
    //         'max_tokens' => 300,
    //         'top_p' => 1.0,
    //         'frequency_penalty' => 0.0,
    //         'presence_penalty' => 0.0,
    //     ]);

    //     return view('chatgpt.response', ['response' => $response->choices[0]->text]);
    // }



}
