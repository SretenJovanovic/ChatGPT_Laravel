<x-app-layout :chats="$chats">
    
    <div class="max-h-max h-full flex-column max-w-full mb-32">
        <!-- main content page -->
        <div class="flex-column mt-3 m-auto mb-16">
            @isset($currentChat)
                @foreach ($currentChat as $chat)
                    <div class="flex-column">
                        <div class="w-full">
                            <div class="pl-60 bg-white font-bold border-b-2 border-gray-200 text-lg p-3 w-full">
                                <p class="mr-10 text-justify">
                                    {{ $chat->message->question }}
                                </p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="pl-60 min-h-full bg-gray-100 border-b-2 border-gray-200 p-3 w-full">
                                <p class="mr-32 text-justify">
                                    {{ $chat->message->answer }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <x-chat-input></x-chat-input>
        
    </div>
</x-app-layout>

