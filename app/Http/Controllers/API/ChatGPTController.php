<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ChatGPTController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    //     return $this->success('',  $response->choices[0]->text, 200);
    // }
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
                "stop" => ["6."],
            ])
            ->json();

        return response()->json($data['choices'][0]['message']['content'], 200, array(), JSON_PRETTY_PRINT);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
