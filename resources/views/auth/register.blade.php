<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIREMA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 overflow-y-auto">

    <div class="min-h-screen flex">

        <!-- LEFT SIDE -->
        <div
            class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-[#071739] via-[#0B1736] to-[#2952E3]">

            <!-- Blur Background -->
            <div class="absolute top-[-80px] left-[-80px] w-72 h-72 rounded-full bg-blue-400/20 blur-3xl"></div>
            <div class="absolute bottom-[-100px] right-[-50px] w-96 h-96 rounded-full bg-indigo-400/20 blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-center w-full px-16 py-14 mb-16 text-white">

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

                    <h2 class="text-5xl xl:text-6xl font-extrabold leading-tight mb-6">
                        Mulai Perjalanan
                        <span class="text-blue-300">
                            Magangmu
                        </span>
                    </h2>

                    <p class="text-slate-300 text-lg leading-9">
                        Daftarkan akun mahasiswa untuk mendapatkan
                        rekomendasi tempat magang terbaik menggunakan
                        metode
                        <span class="font-bold text-white">AHP</span>
                        dan
                        <span class="font-bold text-white">WASPAS</span>.
                    </p>

                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center p-8 py-14 bg-gradient-to-br from-slate-100 to-slate-200">

            <div class="w-full max-w-lg">

                <!-- Header -->
                <div class="text-center mb-8">



                    <h2 class="text-4xl font-bold text-slate-800">
                        Registrasi Mahasiswa
                    </h2>



                </div>

                <!-- Register Card -->
                <div
                    class="rounded-[36px] bg-white border border-slate-200 shadow-2xl p-8 transition-all duration-300 hover:-translate-y-1">

                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <!-- Name -->
                        <div class="field-group mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Lengkap
                            </label>

                            <input id="name" type="text" name="name" onclick="hideValidation(this)"
                                oninput="hideValidation(this)" value="{{ old('name') }}" required
                                placeholder="Masukkan nama lengkap"
                                class="form-input w-full rounded-2xl border border-slate-300 bg-slate-50 py-3.5 px-5 outline-none transition duration-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                            @error('name')
                            <div class="validation-message mt-3 rounded-2xl border border-red-200 bg-red-50 p-4">

                                <div class="flex items-start gap-3">

                                    <div class="text-red-500 text-lg">
                                        ⚠️
                                    </div>

                                    <div>
                                        <h4 class="font-semibold text-red-700">
                                            Nama Tidak Valid
                                        </h4>

                                        <p class="text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    </div>

                                </div>

                            </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="field-group mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Email
                            </label>

                            <input id="email" type="email" name="email" onclick="hideValidation(this)"
                                oninput="hideValidation(this)" value="{{ old('email') }}" required
                                placeholder="Masukkan email"
                                class="form-input w-full rounded-2xl border border-slate-300 bg-slate-50 py-3.5 px-5 outline-none transition duration-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                            @error('email')
                            <div class="validation-message mt-3 rounded-2xl border border-red-200 bg-red-50 p-4">

                                <div class="flex items-start gap-3">

                                    <div class="text-red-500 text-lg">
                                        ⚠️
                                    </div>

                                    <div>
                                        <h4 class="font-semibold text-red-700">
                                            Email Tidak Valid
                                        </h4>

                                        <p class="text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    </div>

                                </div>

                            </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="field-group mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Password
                            </label>

                            <input id="password" type="password" name="password" onclick="hideValidation(this)"
                                oninput="hideValidation(this)" required placeholder="Minimal 8 karakter"
                                class="form-input w-full rounded-2xl border border-slate-300 bg-slate-50 py-3.5 px-5 outline-none transition duration-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                            @if(
                            $errors->has('password')
                            &&
                            !str_contains(
                            $errors->first('password'),
                            'Konfirmasi password'
                            )
                            )

                            <div class="validation-message mt-3 rounded-2xl border border-red-200 bg-red-50 p-4">

                                <div class="flex items-start gap-3">

                                    <div class="text-red-500 text-lg">
                                        ⚠️
                                    </div>

                                    <div>
                                        <h4 class="font-semibold text-red-700">
                                            Password Tidak Valid
                                        </h4>

                                        <p class="text-sm text-red-600">
                                            {{ $errors->first('password') }}
                                        </p>
                                    </div>

                                </div>

                            </div>
                            @endif
                        </div>

                        <!-- Confirm Password -->
                        <div class="field-group mb-7">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Konfirmasi Password
                            </label>

                            <input id="password_confirmation" type="password" name="password_confirmation"
                                onclick="hideValidation(this)" oninput="hideValidation(this)" required
                                placeholder="Ulangi password"
                                class="form-input w-full rounded-2xl border border-slate-300 bg-slate-50 py-3.5 px-5 outline-none transition duration-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                            @if(
                            $errors->has('password')
                            &&
                            str_contains(
                            $errors->first('password'),
                            'Konfirmasi password'
                            )
                            )

                            <div class="validation-message mt-3 rounded-2xl border border-red-200 bg-red-50 p-4">

                                <div class="flex items-start gap-3">

                                    <div class="text-red-500 text-lg">
                                        ⚠️
                                    </div>

                                    <div>
                                        <h4 class="font-semibold text-red-700">
                                            Konfirmasi Password Salah
                                        </h4>

                                        <p class="text-sm text-red-600">
                                            {{ $errors->first('password') }}
                                        </p>
                                    </div>

                                </div>

                            </div>
                            @endif
                        </div>

                        <!-- Button -->
                        <button type="submit" onclick="
        this.disabled=true;
        this.innerText='Memproses...';
        this.form.submit();"
                            class="w-full rounded-2xl bg-gradient-to-r from-[#071739] to-[#2952E3] py-4 font-bold text-white shadow-lg transition duration-300 hover:scale-[1.02] hover:brightness-110">
                            Daftar Sekarang
                        </button>

                        <!-- Login -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-slate-500">
                                Sudah punya akun?

                                <a href="{{ route('login') }}"
                                    class="font-semibold text-blue-600 hover:text-blue-800 transition">
                                    Login sekarang
                                </a>
                            </p>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" id="errorField" value="
    @if($errors->has('name'))
        name
    @elseif($errors->has('email'))
        email
    @elseif(
        $errors->has('password') &&
        str_contains(
            $errors->first('password'),
            'Konfirmasi password'
        )
    )
        password_confirmation
    @elseif($errors->has('password'))
        password
    @endif
">


    <script>
    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const errorField =
                document.getElementById(
                    'errorField'
                )?.value.trim();

            if (!errorField) return;

            const field =
                document.getElementById(
                    errorField
                );

            if (field) {

                field.focus();

                field.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
    );

    function hideValidation(input) {

        const fieldGroup =
            input.closest('.field-group');

        if (!fieldGroup) return;

        const validation =
            fieldGroup.querySelector(
                '.validation-message'
            );

        if (validation) {

            validation.classList.add(
                'transition-all',
                'duration-300',
                'opacity-0',
                '-translate-y-1'
            );

            setTimeout(() => {
                validation.remove();
            }, 300);
        }
    }
    </script>


</body>

</html>
