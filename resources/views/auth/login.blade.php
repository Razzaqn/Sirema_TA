<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIREMA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 overflow-hidden">

    <div class="min-h-screen flex">

        <!-- LEFT SIDE -->
        <div
            class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-[#071739] via-[#0B1736] to-[#2952E3]">

            <!-- Blur Background -->
            <div class="absolute top-[-80px] left-[-80px] w-72 h-72 rounded-full bg-blue-400/20 blur-3xl"></div>
            <div class="absolute bottom-[-100px] right-[-50px] w-96 h-96 rounded-full bg-indigo-400/20 blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-center space-y-6 w-full px-16 py-14 text-white">

                <!-- Logo -->
                <div class="mb-8">
                    <img src="{{ asset('images/sirema2.png') }}" alt="Logo SIREMA" class="w-36 h-auto object-contain">
                </div>

                <!-- Content -->
                <div class="max-w-xl">

                    <span
                        class="inline-flex items-center rounded-full bg-blue-500/20 px-4 py-2 text-sm font-medium text-blue-200 border border-white/10 mb-5">
                        Sistem Pendukung Keputusan
                    </span>

                    <h2 class="text-5xl xl:text-5xl font-extrabold leading-tight mb-6">
                        Temukan
                        <span class="text-blue-300">
                            Tempat Magang
                        </span>
                        Terbaikmu
                    </h2>

                    <p class="text-slate-300 text-lg leading-9">
                        Sistem rekomendasi tempat magang mahasiswa
                        menggunakan metode
                        <span class="font-bold text-white">
                            AHP
                        </span>
                        dan
                        <span class="font-bold text-white">
                            WASPAS
                        </span>
                        untuk membantu menentukan tempat magang
                        terbaik secara objektif.
                    </p>

                </div>

                <!-- Bottom Cards -->
                <div class="flex gap-6 pt-4">

                    <div class="rounded-[28px] border border-white/10 bg-white/10 backdrop-blur-md p-5 w-52 shadow-xl">
                        <h3 class="text-3xl font-bold">
                            AHP
                        </h3>

                        <p class="text-sm text-slate-300 mt-2 leading-6">
                            Menentukan bobot prioritas kriteria.
                        </p>
                    </div>

                    <div class="rounded-[28px] border border-white/10 bg-white/10 backdrop-blur-md p-5 w-52 shadow-xl">
                        <h3 class="text-3xl font-bold">
                            WASPAS
                        </h3>

                        <p class="text-sm text-slate-300 mt-2 leading-6">
                            Menghasilkan rekomendasi terbaik.
                        </p>
                    </div>

                </div>

            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-slate-100 to-slate-200">

            <div class="w-full max-w-lg">
                @if(session('success'))
                <div id="success-alert"
                    class="mb-5 rounded-2xl border border-green-200 bg-green-50 p-4 shadow-sm transition-all duration-500">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
                            ✅
                        </div>

                        <div>
                            <h4 class="font-semibold text-green-800">
                                Registrasi Berhasil
                            </h4>

                            <p class="text-sm text-green-700">
                                {{ session('success') }}
                            </p>
                        </div>

                    </div>

                </div>
                @endif

                <!-- Header -->
                <div class="text-center mb-8">



                    <h2 class="text-4xl font-bold text-slate-800">
                        Selamat Datang
                    </h2>



                </div>

                <!-- Login Card -->
                <div
                    class="rounded-[36px] bg-white border border-slate-200 shadow-2xl p-8 transition-all duration-300 hover:-translate-y-1 hover:shadow-3xl">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-5">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Email
                            </label>

                            <div class="relative">

                                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                    placeholder="Masukkan email"
                                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 py-3.5 px-5 outline-none transition duration-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                            </div>

                            @error('email')
                            <p class="text-sm text-red-500 mt-2">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>

                        <!-- Password -->
                        <div class="mb-5">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Password
                            </label>

                            <div class="relative">

                                <input type="password" name="password" id="password" required
                                    placeholder="Masukkan password"
                                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 py-3.5 px-5 pr-14 outline-none transition duration-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                                <button type="button" onclick="togglePassword()"
                                    class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0
            3 3 0 016 0zm6 0s-3 6-9
            6-9-6-9-6 3-6 9-6
            9 6 9 6z" />
                                    </svg>
                                </button>

                            </div>

                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between mb-7">

                            <label class="flex items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" name="remember" class="rounded border-slate-300">

                                Ingat saya
                            </label>

                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                                Lupa password?
                            </a>
                            @endif

                        </div>

                        <!-- Login Button -->
                        <button type="submit" onclick="
        this.disabled=true;
        this.innerText='Memproses...';
        this.form.submit();
    " class="w-full rounded-2xl bg-gradient-to-r from-[#071739] to-[#2952E3] py-3.5 font-bold text-white shadow-lg transition duration-300 hover:scale-[1.02] hover:shadow-2xl hover:brightness-110">
                            Login
                        </button>

                        <!-- Register -->
                        <div class="mt-6 text-center">

                            <p class="text-sm text-slate-500">
                                Belum punya akun?

                                <a href="{{ route('register') }}"
                                    class="font-semibold text-blue-600 hover:text-blue-800 transition">
                                    Daftar sekarang
                                </a>
                            </p>

                        </div>

                    </form>
                </div>

                <p class="text-center text-sm text-slate-500 mt-8">
                    © {{ date('Y') }} SIREMA — Sistem Rekomendasi Magang
                </p>

            </div>

        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const alertBox =
            document.getElementById('success-alert');

        if (alertBox) {

            setTimeout(() => {

                // efek fade out
                alertBox.classList.add(
                    'opacity-0',
                    '-translate-y-2'
                );

                // hapus element setelah animasi
                setTimeout(() => {
                    alertBox.remove();
                }, 500);

            }, 2000); // 2 detik
        }
    });

    function togglePassword() {
        const password = document.getElementById('password');

        password.type =
            password.type === 'password' ?
            'text' :
            'password';
    }
    </script>

</body>

</html>
