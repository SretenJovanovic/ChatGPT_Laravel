<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\Failed\PrunableFailedJobProvider;

class ChatGPTService
{

    public function answerChatGPT($chatNo,string $question): array
    {
        $data = $this->askChatGPT($question);

        // If limit is reached return
        // TODO Alert message (try again later)
        if(!isset($data['choices'])){
            $answer = 'Limit reached';
            return ['chatNo'=>$chatNo,'sentences'=>[$answer]];
        }else {
            $answer = $data['choices'][0]['message']['content'];
        }
        $chatNo=$this->insertChatIntoDB($data, $question, $answer, $chatNo);
        $sentences = $this->splitIntoSentences($answer);
        return ['chatNo'=>$chatNo,'sentences'=>$sentences];
    }


    public function askChatGPT($question)
    {
        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])
            ->post("https://api.openai.com/v1/chat/completions", [
                "model" => "gpt-3.5-turbo",
                'messages' => [
                    [
                        "role" => "user",
                        "content" => $question
                    ]
                ],
                'temperature' => 0.5,
                "max_tokens" => 200,
                "top_p" => 1.0,
                "frequency_penalty" => 0.52,
                "presence_penalty" => 0.5,
                "stop" => ["11."],
            ])
            ->json();
            
        return $data;
    }

    public function insertChatIntoDB($data, $question, $answer, $chatNo)
    {
        $answerID = $data['id'];
        $message = new Message;
        $message->answer_id = $answerID;
        $message->question = $question;
        $message->answer = $answer;
        $message->save();
        $messageID = $message->id;

        $chat = new Chat();
        $chat->chatNo = $chatNo;
        $chat->user_id = auth()->id();
        $chat->message_id = $messageID;
        $chat->save();
        return $chat->chatNo;
    }

    public function splitIntoSentences($answer)
    {
        $sentences = preg_split('/(?<=[.?!])\s+(?=\p{Lu})|\d+\.\s+/', $answer, -1, PREG_SPLIT_NO_EMPTY);
        // Trim whitespace from each sentence
        $sentences = array_map('trim', $sentences);
        return $sentences;
    }

    public function startNewChat(){

        $lastChatId = Chat::latest()->first();
        if(!$lastChatId){
            $lastChatId=1;
        }else {
            $lastChatId = Chat::latest()->first()->chatNo;
            $lastChatId+=1;
        }
        return $lastChatId;
    }
}
