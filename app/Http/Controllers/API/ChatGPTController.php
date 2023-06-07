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
  
    public function ask(Request $request)
    {
        $search = $request->input('prompt');
        if($search == ''){
            return $this->error($search,'Prompt cannot be empty...',404);
        }

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
    
}
