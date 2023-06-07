<nav x-data="{ open: false }"
    class="w-1/5 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="w-64 fixed min-h-screen border bg-gray-900 border-black mx-auto">

        <div class="flex-column h-screen w-full">
            <div class="flex-column h-20">
                <!-- Logo -->
                <div class="max-h-full">
                    <a href="{{ route('chatgpt.new') }}"
                        class="flex m-2 py-3 px-3 items-center gap-3 transition-colors duration-200 text-white cursor-pointer text-sm rounded-md border border-white/20 hover:bg-gray-500/10 mb-1 flex-shrink-0">
                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em"
                            xmlns="http://www.w3.org/2000/svg">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>New chat
                    </a>
                </div>
                <div class="min-h-screen">
                    <div class="h-[75vh] overflow-auto scrollbar-hide whitespace-nowrap">
                        <div>
                            <h3 class='text-gray-500 text-md font-medium py-3 px-5'>Previous 7 Days</h3>
                        </div>
    
                        {{-- Chat History --}}
                        @isset($attributes['chats'])
                        <ul class="mb-6">
                            @foreach ($attributes['chats'] as $i => $chat)
                            <a href='#' class="text-slate-200 text-md">
                                <li class="hover:bg-gray-600 p-2 rounded-md mx-2 overflow-hidden">
                                        #{{ $i+1 }} : {{ $chat->message->question }}
                                    </li>
                            </a>
                            @endforeach
                        </ul>
                        @endisset
                    </div>
                </div>
                

                <!-- Settings Dropdown -->
                <div class="h-36 bg-gray-800 bottom-0 z-40 absolute hidden sm:flex sm:items-center w-64 border-t-2 border-gray-200">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                class="w-60 inline-flex items-center mx-2 px-2 py-3 border border-gray-500 text-sm leading-4 font-medium rounded-md text-white hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>



            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">


        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
