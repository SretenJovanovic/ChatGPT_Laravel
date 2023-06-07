<div>
    <form method="POST" class="fixed bottom-10 w-3/5 left-1/3" action="{{ route('chatgpt.question') }}">
        @csrf

        @isset($chatNo)
            <input type="hidden" name="chatNo" value="{{ $chatNo }}">
        @endisset

        <div class="z-50 flex w-full px-20 mb-1">
            <input type="text"
                class="w-full shadow-lg border-gray-200 bg-white text-md rounded-2xl h-14 text-left focus:ring-0 focus:border-gray-500"
                name="prompt" placeholder="Send a message.">
            <button type="submit"
                class="absolute right-20 m-2 py-3 px-3 text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none" class="h-4 w-4"
                    stroke-width="2">
                    <path
                        d="M.5 1.163A1 1 0 0 1 1.97.28l12.868 6.837a1 1 0 0 1 0 1.766L1.969 15.72A1 1 0 0 1 .5 14.836V10.33a1 1 0 0 1 .816-.983L8.5 8 1.316 6.653A1 1 0 0 1 .5 5.67V1.163Z"
                        fill="currentColor"></path>
                </svg>
            </button>
        </div>
    </form>
</div>