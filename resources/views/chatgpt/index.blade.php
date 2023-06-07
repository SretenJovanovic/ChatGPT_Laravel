<x-app-layout :chats="$chats">
    <div class="max-h-screen h-full flex-column">
        <!-- main content page -->
        <div class="w-full p-4">
            <h2 class="text-4xl font-extrabold text-gray-800 text-center my-20">
                ChatGPT
            </h2>
        </div>

        <x-chat-input></x-chat-input>
    </div>
</x-app-layout>
