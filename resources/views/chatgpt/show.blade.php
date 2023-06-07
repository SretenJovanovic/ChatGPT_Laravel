<x-app-layout>
    <div class="flex">
        <!-- aside -->
        <aside class="flex w-auto flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2" style="height: 90.5vh"
            x-show="asideOpen">

            <h2 class="ml-5 mt-3 font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('ChatGPT - Chat History') }}
            </h2>
            <hr>

            <ul>
                @foreach ($chats as $i => $chat)
                    <li class="bg-slate-100 mt-1">
                        <a href="{{ route('chatgpt.show', $chat->id) }}" class="text-blue-800 text-xl">
                            #{{ $i + 1 }} : {{ $chat->question }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <!-- main content page -->
        <div class="w-full p-4">
            <h3>{{ $myChat->question }}</h3>
            @foreach ($myChat->answer as $i=>$answer)
                <p>#{{ $i+1 }} : {{ $answer }}</p>
            @endforeach
            <p>Created at: {{ $myChat->created_at->diffForHumans()}}</p>
        </div>
    </div>
</x-app-layout>
