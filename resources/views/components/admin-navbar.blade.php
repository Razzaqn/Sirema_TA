<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left Menu -->
            <div class="flex">
                <!-- Logo / Title -->
                <div class="shrink-0 flex items-center font-bold text-lg">
                    Admin Panel
                </div>

                <!-- Menu -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link href="#" :active="request()->is('admin/users')">
                        Kelola User
                    </x-nav-link>

                </div>
            </div>

            <!-- Right Menu -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                            <div>{{ Auth::user()->name ?? 'Admin' }}</div>

                            <div class="ml-1">
                                ▼
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="#">
                            Profil
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                Dashboard
            </x-responsive-nav-link>

        </div>

        <div class="pt-4 pb-1 border-t">
            <div class="px-4">
                <div class="font-medium text-base">
                    {{ Auth::user()->name ?? 'Admin' }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email ?? '-' }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
