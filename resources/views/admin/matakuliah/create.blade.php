@extends('layouts.admin')

@section('content')

<!-- Breadcrumb -->
<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">
        Dashboard
    </a>

    <span>/</span>

    <a href="{{ route('mk.index') }}" class="hover:text-blue-600 transition">
        Mata Kuliah
    </a>

    <span>/</span>

    <span class="font-medium text-blue-600">
        Tambah
    </span>
</nav>



<!-- Card -->
<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

        <!-- Header Card -->
        <div class="px-8 py-6 border-b bg-gray-50">

            <h2 class="text-xl font-semibold text-gray-800">
                Form Tambah Mata Kuliah
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Lengkapi seluruh informasi di bawah ini.
            </p>

        </div>

        <!-- Body -->
        <div class="p-8">

            @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                <div class="font-semibold text-red-700 mb-2">
                    Terjadi kesalahan
                </div>

                <ul class="list-disc ml-5 text-sm text-red-600">

                    @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

            @endif

            <form action="{{ route('mk.store') }}" method="POST">

                @csrf

                <!-- Nama -->
                <div class="mb-6">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Nama Mata Kuliah
                        <span class="text-red-500">*</span>

                    </label>

                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh : Pemrograman Web"
                        class="w-full rounded-xl border-gray-300
                        focus:border-blue-500
                        focus:ring-blue-500">

                </div>

                <!-- Bidang -->
                <div class="mb-6">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Bidang Kompetensi
                        <span class="text-red-500">*</span>

                    </label>

                    <!-- Bidang -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Bidang Kompetensi
                            <span class="text-red-500">*</span>

                        </label>

                        <p class="text-sm text-gray-500 mb-4">
                            Pilih satu atau lebih bidang yang sesuai dengan kompetensi mata kuliah.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                            @foreach($bidangValid as $bidang)

                            <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200
                   hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition">

                                <input type="checkbox" name="bidang[]" value="{{ $bidang }}"
                                    {{ in_array($bidang, old('bidang', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600
                       focus:ring-blue-500">

                                <span class="text-sm font-medium text-gray-700">
                                    {{ $bidang }}
                                </span>

                            </label>

                            @endforeach

                        </div>

                        @error('bidang')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                        @enderror

                        @error('bidang.*')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                </div>

                <!-- Semester -->
                <div class="mb-8">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Semester
                        <span class="text-red-500">*</span>

                    </label>

                    <select name="semester" class="w-full rounded-xl border-gray-300
           focus:border-blue-500
           focus:ring-blue-500">

                        @for($i = 1; $i <= 3; $i++) <option value="{{ $i }}"
                            {{ old('semester', 1) == $i ? 'selected' : '' }}>

                            Semester {{ $i }}

                            </option>

                            @endfor

                    </select>

                </div>

                <!-- Tips -->
                <div class="mb-8 rounded-xl bg-blue-50 border border-blue-100 p-4">

                    <h4 class="font-semibold text-blue-700">

                        Informasi

                    </h4>

                    <p class="text-sm text-blue-600 mt-1">

                        Mata kuliah yang ditambahkan akan digunakan
                        dalam proses perhitungan profil kompetensi mahasiswa.

                    </p>

                </div>

                <!-- Button -->
                <div class="flex justify-end gap-3">

                    <a href="{{ route('mk.index') }}" class="px-6 py-3 rounded-xl
                        border
                        border-gray-300
                        hover:bg-gray-100
                        transition">

                        Kembali

                    </a>

                    <button type="submit" class="px-6 py-3 rounded-xl
                        bg-blue-600
                        hover:bg-blue-700
                        text-white
                        shadow-md
                        transition">

                        Simpan Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
