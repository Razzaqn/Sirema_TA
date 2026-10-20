<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <!-- SIDEBAR -->
        <aside class="w-72 bg-slate-900 text-white flex flex-col">

            {{-- Logo --}}
            <div class="px-6 py-6 border-b border-slate-800">

                <h1 class="text-2xl font-bold tracking-wide">
                    SIREMA
                </h1>

                <p class="text-sm text-slate-400 mt-1">
                    Admin
                </p>

            </div>

            {{-- Menu --}}
            <div class="flex-1 px-4 py-6 overflow-y-auto">

                <p class="text-xs uppercase tracking-widest text-slate-500 mb-3 px-3">
                    Menu
                </p>

                <nav class="space-y-2">

                    {{-- Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-600 text-white shadow'
                    : 'hover:bg-slate-800 text-slate-300' }}">

                        <span>Dashboard</span>

                    </a>

                    <p class="text-xs uppercase tracking-widest text-slate-500 mt-6 mb-3 px-3">
                        Data Master
                    </p>

                    {{-- Mata Kuliah --}}
                    <a href="{{ route('mk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('mk.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'hover:bg-slate-800 text-slate-300' }}">

                        <span>Mata Kuliah</span>

                    </a>

                    {{-- Industri --}}
                    <a href="{{ route('industry.listindustry') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('industry.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'hover:bg-slate-800 text-slate-300' }}">

                        <span>Data Perusahaan</span>

                    </a>

                    {{-- Wilayah --}}
                    <a href="{{ route('master-wilayah.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('master-wilayah.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'hover:bg-slate-800 text-slate-300' }}">

                        <span>Master Wilayah</span>

                    </a>

                </nav>

            </div>

            {{-- User --}}
            <div class="border-t border-slate-800 p-5">



                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button class="w-full bg-red-500 hover:bg-red-600 transition rounded-xl py-3 font-semibold">

                        Logout

                    </button>

                </form>

            </div>

        </aside>

        <!-- CONTENT -->
        <div class="flex-1 flex flex-col">

            <!-- TOPBAR -->
            @php
            \Carbon\Carbon::setLocale('id');
            @endphp
            <header class="bg-white border-b border-gray-200 px-8 py-5 flex items-center justify-between">

                <!-- Judul Halaman -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Dashboard Admin
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Kelola seluruh data Sistem Rekomendasi Tempat Magang Mahasiswa (SIREMA)
                    </p>
                </div>

                <!-- Bagian Kanan -->
                <div class="flex items-center gap-5">

                    <!-- Tanggal -->
                    <div class="hidden md:block text-right">
                        <p class="text-sm text-gray-500">
                            {{ now()->translatedFormat('l') }}
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ now()->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <!-- Garis -->
                    <div class="h-10 w-px bg-gray-200"></div>

                    <!-- User -->
                    <div class="flex items-center gap-3">

                        <div class="text-right">

                            <p class="font-semibold text-gray-800">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Administrator
                            </p>

                        </div>

                        <div
                            class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg">

                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                        </div>

                    </div>

                </div>

            </header>

            <!-- MAIN -->
            <main class="p-6 overflow-y-auto">
                @yield('content')
            </main>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
