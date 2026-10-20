<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lupa Password - SIREMA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <div class="min-h-screen flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-md">

            {{-- ================================
                BRANDING SIREMA
            ================================= --}}
            <div class="text-center mb-7">

                <div class="flex justify-center mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#1e3a5f] flex items-center justify-center shadow-lg">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14.5a4 4 0 100-8 4 4 0 000 8z" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20a7.5 7.5 0 0115 0" />
                        </svg>

                    </div>
                </div>

                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                    SIREMA
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Sistem Rekomendasi Tempat Magang
                </p>

            </div>


            {{-- ================================
                CARD LUPA PASSWORD
            ================================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-7 py-8">

                {{-- Header --}}
                <div class="text-center mb-6">

                    <div class="mx-auto mb-4 w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#1e3a5f]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V8a4.5 4.5 0 00-9 0v2.5" />

                            <rect width="15" height="11" x="4.5" y="10.5" rx="2" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.5v1.5" />

                        </svg>

                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">
                        Lupa Password?
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Masukkan email yang terdaftar pada
                        akun SIREMA dan kami akan mengirimkan tautan untuk
                        membuat password baru.
                    </p>

                </div>


                {{-- ================================
                    SESSION STATUS
                ================================= --}}
                @if (session('status'))
                <div class="mb-4 rounded-xl bg-green-50 border border-green-100 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
                @endif


                {{-- ================================
                    FORM RESET PASSWORD
                ================================= --}}
                <form method="POST" action="{{ route('password.email') }}">

                    @csrf

                    {{-- Email --}}
                    <div>

                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>

                        <div class="relative mt-2">

                            {{-- Email Icon --}}
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6" />

                                    <rect width="18" height="14" x="3" y="5" rx="2" />

                                </svg>

                            </div>

                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="Masukkan email Anda" required autofocus autocomplete="email" class="block w-full pl-10 pr-4 py-3 rounded-xl
                                       border border-gray-200
                                       focus:border-[#1e3a5f]
                                       focus:ring-[#1e3a5f]
                                       text-sm outline-none transition">

                        </div>

                        {{-- Error --}}
                        @if ($errors->has('email'))
                        <p class="mt-2 text-sm text-red-600">
                            {{ $errors->first('email') }}
                        </p>
                        @endif

                    </div>


                    {{-- ================================
                        BUTTON
                    ================================= --}}
                    <div class="mt-6">

                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2
                                   px-5 py-3 rounded-xl
                                   bg-[#1e3a5f] hover:bg-[#162f4d]
                                   text-white text-sm font-semibold
                                   transition duration-200
                                   focus:outline-none focus:ring-2
                                   focus:ring-[#1e3a5f] focus:ring-offset-2">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6" />

                                <rect width="18" height="14" x="3" y="5" rx="2" />

                            </svg>

                            KIRIM LINK RESET PASSWORD

                        </button>

                    </div>

                </form>


                {{-- ================================
                    KEMBALI KE LOGIN
                ================================= --}}
                <div class="mt-6 pt-5 border-t border-gray-100 text-center">

                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2
                               text-sm font-medium text-gray-500
                               hover:text-[#1e3a5f]
                               transition duration-200">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>

                        Kembali ke halaman Login

                    </a>

                </div>

            </div>


            {{-- ================================
                FOOTER
            ================================= --}}
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} SIREMA
            </p>

        </div>

    </div>

</body>

</html>
