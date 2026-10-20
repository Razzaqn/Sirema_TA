<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIREMA</title>

    <link rel="stylesheet" href="{{ asset('css/ahp.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-[Poppins] ">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen">

        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'w-60' : 'w-20'" class="fixed top-0 left-0 z-50 h-screen
           bg-white border-r border-gray-200
           transition-all duration-300
           shadow-sm flex flex-col">

            <!-- HEADER -->
            <div class="relative h-16 border-b flex items-center justify-between px-4">

                <div class="flex items-center justify-center h-16 border-b">

                    <img src="{{ asset('images/sirema2.png') }}" class="w-10">

                    <div x-show="sidebarOpen" x-transition.opacity.duration.300ms class="ml-3">
                        <h2 class="font-bold text-gray-800">SIREMA</h2>
                        <p class="text-xs text-gray-500">Internship</p>
                    </div>

                </div>

                <!-- BUTTON -->
                <button @click="sidebarOpen = !sidebarOpen" class="absolute
           -right-4
           top-1/2
           -translate-y-1/2
           h-8
           w-8
           rounded-full
           bg-white
           border
           shadow-lg
           flex
           items-center
           justify-center">


                    <i :class="sidebarOpen ? 'ri-arrow-left-s-line':'ri-arrow-right-s-line'"
                        class="text-xl text-gray-500"></i>

                </button>

            </div>

            @php
            $qualificationComplete = Auth::user()->isQualificationComplete();
            @endphp

            <!-- MENU -->
            <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-2">

                <!-- Dashboard -->
                <a href="/dashboard" class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300
            {{ request()->routeIs('dashboard')
                ? 'bg-blue-600 text-white shadow-md'
                : 'text-gray-600 hover:bg-gray-100' }}">

                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                {{ request()->routeIs('dashboard')
                    ? 'bg-white/20'
                    : 'bg-gray-100 group-hover:bg-blue-600 group-hover:text-white' }} ">

                        <i class="ri-dashboard-line w-5 text-center text-lg"></i>

                    </div>

                    <span x-show="sidebarOpen" x-transition class="font-medium whitespace-nowrap">

                        Dashboard

                    </span>

                </a>

                <!-- Kompetensi -->
                <a href="{{ route('profil.index') }}" class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300
   {{ request()->routeIs('profil.*')
      ? 'bg-blue-600 text-white shadow-md'
      : 'text-gray-600 hover:bg-gray-100' }}">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl
        {{ request()->routeIs('profil.*')
            ? 'bg-white/20 text-white'
            : 'bg-gray-100 text-gray-500 group-hover:bg-blue-600 group-hover:text-white' }}">

                        <i class="ri-user-star-line w-5 text-center text-lg"></i>

                    </div>

                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap ">

                        Kualifikasi

                    </span>

                </a>

                <!-- Perangkingan -->
                @if($qualificationComplete)

                <a href="{{ route('rekomendasi') }}" class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300
    {{
        request()->routeIs('rekomendasi') ||
        request()->routeIs('rekomendasi.bobot') ||
        request()->routeIs('rekomendasi.waspas') ||
        request()->routeIs('rekomendasi.ranking')
        ? 'bg-blue-600 text-white shadow-md'
        : 'text-gray-600 hover:bg-gray-100'
    }}">

                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
    {{
        request()->routeIs('rekomendasi') ||
        request()->routeIs('rekomendasi.bobot') ||
        request()->routeIs('rekomendasi.waspas') ||
        request()->routeIs('rekomendasi.ranking')
        ? 'bg-white/20'
        : 'bg-gray-100 group-hover:bg-blue-600 group-hover:text-white'
    }}">

                        <i class="ri-star-line w-5 text-center text-lg"></i>

                    </div>

                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">
                        Perangkingan
                    </span>

                </a>

                @else

                <a href="javascript:void(0)" onclick="showQualificationWarning()"
                    class="group flex items-center gap-3 px-3 py-3 rounded-xl text-gray-400 cursor-not-allowed">

                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-100">

                        <i class="ri-lock-line w-5 text-center text-lg"></i>

                    </div>

                    <span x-show="sidebarOpen" class="font-medium whitespace-nowrap flex items-center gap-2">

                        Perangkingan



                    </span>

                </a>

                @endif

                <!-- History -->
                <a href="{{ route('rekomendasi.history') }}" class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300
            {{ request()->routeIs('rekomendasi.history')
                ? 'bg-blue-600 text-white shadow-md'
                : 'text-gray-600 hover:bg-gray-100' }}">

                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                {{ request()->routeIs('rekomendasi.history')
                    ? 'bg-white/20'
                    : 'bg-gray-100 group-hover:bg-blue-600 group-hover:text-white' }}">

                        <i class="ri-history-line w-5 text-center text-lg"></i>

                    </div>

                    <span x-show="sidebarOpen" x-transition class="font-medium whitespace-nowrap">

                        History

                    </span>

                </a>

                <!-- Perusahaan -->
                <a href="{{ route('industryuser.index') }}" class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300
            {{ request()->routeIs('industryuser.*')
                ? 'bg-blue-600 text-white shadow-md'
                : 'text-gray-600 hover:bg-gray-100' }}">

                    <div class="flex items-center justify-center w-10 h-10 rounded-xl
                {{ request()->routeIs('industryuser.*')
                    ? 'bg-white/20'
                    : 'bg-gray-100 group-hover:bg-blue-600 group-hover:text-white' }}">

                        <i class="ri-building-line w-5 text-center text-lg"></i>

                    </div>

                    <span x-show="sidebarOpen" x-transition class="font-medium whitespace-nowrap">

                        Perusahaan

                    </span>

                </a>

            </nav>

            <!-- FOOTER -->
            @if(!$profilLengkap)

            <div class="mt-auto border-t p-3">

                <div x-show="sidebarOpen" x-transition class="rounded-2xl bg-amber-50 border border-amber-200 p-4">

                    <div class="flex items-center gap-2">

                        <i class="ri-error-warning-line text-amber-500"></i>

                        <h4 class="font-semibold text-amber-700 text-sm">

                            Kualifikasi Belum Lengkap

                        </h4>

                    </div>

                    <p class="mt-2 text-xs text-gray-600 leading-5">

                        Lengkapi menu kualifikasi agar hasil rekomendasi tempat magang menjadi lebih akurat.

                    </p>

                    <a href="{{ route('profil.index') }}"
                        class="mt-4 block rounded-xl bg-blue-600 py-2 text-center text-sm font-medium text-white hover:bg-blue-700">

                        Lengkapi

                    </a>

                </div>

            </div>

            @endif

        </aside>


        <!-- AREA KANAN -->
        <div :class="sidebarOpen ? 'ml-60' : 'ml-20'" class="flex-1 flex flex-col transition-all duration-300">

            <!-- HEADER -->
            <div :class="sidebarOpen ? 'left-60' : 'left-20'"
                class="h-20 bg-white shadow flex items-center justify-between px-6 fixed top-0  right-0 z-40">
                <h2 class="text-xl font-semibold">
                    @yield('title')
                </h2>

                <div class="flex items-center gap-4">

                    <div class="relative" id="profileMenu">

                        <button onclick="toggleDropdown(event)"
                            class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-2 shadow-sm transition duration-300 hover:shadow-md">
                            <span class="text-sm font-medium text-slate-700">
                                {{ Auth::user()->name ?? 'Guest' }}
                            </span>

                            @php
                            $user = Auth::user();
                            @endphp

                            @if($user && $user->photo)

                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Avatar"
                                class="h-9 w-9 rounded-full object-cover shadow">

                            @else

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-pink-400 text-sm font-bold text-white shadow">

                                {{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}

                            </div>

                            @endif
                        </button>

                        <div id="dropdownProfile"
                            class="hidden absolute right-0 mt-4 w-72 overflow-hidden rounded-[28px] border border-slate-100 bg-white shadow-2xl z-50">

                            <!-- Header User -->
                            <div
                                class="border-b border-slate-200 bg-gradient-to-r from-[#0B1736] to-[#123D82] px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <!-- Avatar -->
                                    @if($user && $user->photo)

                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Avatar"
                                        class="h-10 w-10 rounded-full object-cover shadow">

                                    @else

                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-pink-400 text-xs font-bold text-white shadow">

                                        {{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}

                                    </div>

                                    @endif

                                    <!-- User Info -->
                                    <div class="min-w-0 leading-tight">

                                        <h4 class="truncate text-sm font-semibold text-white">
                                            {{ Auth::user()->name }}
                                        </h4>

                                        <p class="truncate text-xs text-slate-300">
                                            {{ Auth::user()->email }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <!-- Menu -->
                            <div class="py-2">

                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-slate-700 transition duration-200 hover:bg-slate-50 hover:text-blue-600">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                    Profil Saya
                                </a>

                                <button type="button" onclick="openLogoutModal()"
                                    class="flex w-full items-center gap-3 px-5 py-3 text-left text-sm font-medium text-red-500 transition duration-200 hover:bg-red-50 hover:text-red-600">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />
                                    </svg>

                                    Logout
                                </button>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="mt-20 p-6 overflow-y-auto flex-1">
                @yield('content')
            </div>

        </div>

    </div>
    <!-- Hidden Logout Form -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>


    <!-- Logout Modal -->
    <div id="logoutModal" onclick="outsideLogoutClose(event)"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">

        <div id="logoutModalContent"
            class="w-full max-w-md rounded-[32px] bg-white p-8 shadow-2xl scale-95 opacity-0 transition-all duration-300">

            <!-- Icon -->
            <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-red-100 text-4xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />
                </svg>
            </div>

            <h2 class="text-center text-2xl font-bold text-slate-800 mb-2">
                Keluar dari Sistem?
            </h2>

            <p class="text-center text-slate-500 leading-7 mb-8">
                Anda yakin ingin logout dari akun
                <span class="font-semibold text-slate-700">
                    SIREMA
                </span>?
            </p>

            <div class="flex gap-3">

                <button type="button" onclick="closeLogoutModal()"
                    class="flex-1 rounded-2xl border border-slate-300 py-3 font-semibold text-slate-700 transition hover:bg-slate-100 hover:scale-[1.02]">
                    Batal
                </button>

                <button type="button" onclick="confirmLogout()"
                    class="flex-1 rounded-2xl bg-gradient-to-r from-[#B91C1C] to-[#DC2626] py-3 font-semibold text-white shadow-lg transition hover:scale-[1.02]  hover:brightness-110 ">
                    Ya, Logout
                </button>

            </div>

        </div>
    </div>




    @yield('scripts')
    <script>
    function toggleDropdown(event) {
        event.stopPropagation();
        document.getElementById('dropdownProfile').classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('profileMenu');
        const dropdown = document.getElementById('dropdownProfile');

        if (!menu.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    function openModal() {
        console.log("modal dibuka"); // debug
        document.getElementById("modalPanduan").style.display = "block";
    }

    function closeModal() {
        document.getElementById("modalPanduan").style.display = "none";
    }

    // klik luar modal = close
    window.onclick = function(event) {
        let modal = document.getElementById("modalPanduan");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    function openLogoutModal() {

        const modal =
            document.getElementById(
                'logoutModal'
            );

        const content =
            document.getElementById(
                'logoutModalContent'
            );

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            content.classList.remove(
                'scale-95',
                'opacity-0'
            );
        }, 10);
    }


    function closeLogoutModal() {

        const modal =
            document.getElementById(
                'logoutModal'
            );

        const content =
            document.getElementById(
                'logoutModalContent'
            );

        content.classList.add(
            'scale-95',
            'opacity-0'
        );

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }


    function confirmLogout() {

        document
            .getElementById(
                'logout-form'
            )
            .submit();
    }

    function outsideLogoutClose(event) {

        const modalContent =
            document.getElementById(
                'logoutModalContent'
            );

        if (
            !modalContent.contains(
                event.target
            )
        ) {
            closeLogoutModal();
        }
    }

    function showQualificationWarning() {

        Swal.fire({

            icon: 'warning',

            title: 'Perangkingan Terkunci',

            text: 'Silakan lengkapi seluruh Kualifikasi terlebih dahuulu.',

            confirmButtonColor: '#2563eb'

        });

    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    </script>

    @if(session('success'))
    <script>
    Toast.fire({
        icon: 'success',
        title: "{{ session('success') }}"
    });
    </script>
    @endif

    @if(session('warning'))
    <script>
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: "{{ session('warning') }}",
        confirmButtonColor: '#2563eb'
    });
    </script>
    @endif

    @if(session('error'))
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        text: "{{ session('error') }}",
        confirmButtonColor: '#dc2626'
    });
    </script>
    @endif

    @if(session('info'))
    <script>
    Swal.fire({
        icon: 'info',
        title: 'Informasi',
        text: "{{ session('info') }}",
        confirmButtonColor: '#2563eb'
    });
    </script>
    @endif


</body>

</html>
