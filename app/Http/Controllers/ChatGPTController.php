<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\ChatGPTService;
use App\Services\ChatSessionService;
use Illuminate\Support\Facades\Http;

class ChatGPTController extends Controller
{
    public function index()
    {
        
        $user = User::all();
        // Logged user chats
        $chats = Chat::where('user_id', auth()->id())->where( 'created_at', '>', Carbon::now()->subDays(7))->latest()->get();

        return view('chatgpt.index', [
            'user' => $user,
            'chats' => $chats
        ]);
    }
    public function new(ChatGPTService $chatGptService)
    {
        // Initializing new chat number
        $newChatNo = $chatGptService->startNewChat();

        return view('chatgpt.response', [
            'chatNo' => $newChatNo
        ]);
    }
    public function question(Request $request, ChatGPTService $chatGptService)
    {
        // $request->whenHas('chatNo')
        if ($request->input('chatNo') == null) {
            $chatNo = $chatGptService->startNewChat();
        } else {
            $chatNo = $request->input('chatNo');
        }


        $question = $request->input('prompt');
        // Sending POST request to chatGPT API and fetching answer


        $response = $chatGptService->answerChatGPT($chatNo, $question);
        $chatNo = $response['chatNo'];

        $chats = Chat::where('user_id', auth()->id())->latest()->get();

        // Fetching all chats in current chat session with pagination
        $currentChat = Chat::where('chatNo', '=', $chatNo)->where( 'created_at', '>', Carbon::now()->subDays(7))->latest()->paginate(3);
        return view('chatgpt.response', ['chatNo' => $chatNo, 'chats' => $chats,'currentChat'=>$currentChat]);
    }

    public function show(Chat $chat, ChatGPTService $customService)
    {
        $chats = Chat::get();
        $chat->answer = $customService->splitIntoSentences($chat->answer);

        return view('chatgpt.show', [
            'myChat' => $chat,
            'chats' => $chats
        ]);
    }
}
