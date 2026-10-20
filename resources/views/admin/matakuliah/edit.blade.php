@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">

        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">

            Dashboard

        </a>

        <span>/</span>

        <a href="{{ route('mk.index') }}" class="hover:text-blue-600">

            Mata Kuliah

        </a>

        <span>/</span>

        <span class="text-blue-600">

            Edit

        </span>

    </div>

    <div class="bg-white rounded-2xl shadow-md p-8">
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">

                Edit Mata Kuliah

            </h1>

            <p class="text-gray-500 mt-2">

                Perbarui data mata kuliah yang digunakan
                sebagai dasar perhitungan profil kompetensi.

            </p>

        </div>

        <form action="{{ route('mk.update',$data->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">

                <label class="block mb-2 font-semibold text-gray-700">

                    Nama Mata Kuliah

                </label>

                <input type="text" name="nama" value="{{ $data->nama }}"
                    class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                @error('nama')

                <p class="text-red-500 text-sm mt-2">

                    {{ $message }}

                </p>

                @enderror

            </div>
            <div class="mb-6">

                <label class="block mb-2 font-semibold">

                    Bidang Kompetensi

                </label>

                <div class="mb-6">

                    <label class="block mb-2 font-semibold text-gray-700">

                        Bidang Kompetensi

                        <span class="text-red-500">*</span>

                    </label>

                    <p class="text-sm text-gray-500 mb-4">
                        Pilih satu atau lebih bidang yang sesuai dengan kompetensi mata kuliah.
                    </p>

                    @php
                    $bidangTerpilih = $data->bidangKompetensi
                    ->pluck('bidang')
                    ->toArray();
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        @foreach($bidangValid as $bidang)

                        <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200
                   hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition">

                            <input type="checkbox" name="bidang[]" value="{{ $bidang }}"
                                {{ in_array($bidang, $bidangTerpilih) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600
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

                </div>
            </div>
            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Semester
                </label>

                <select name="semester" class="w-full rounded-xl border-gray-300
               focus:border-blue-500
               focus:ring-blue-500">

                    @for($i = 1; $i <= 3; $i++) <option value="{{ $i }}" {{ $data->semester == $i ? 'selected' : '' }}>

                        Semester {{ $i }}

                        </option>

                        @endfor

                </select>

            </div>

            <div class="flex justify-end gap-3 mt-8">

                <a href="{{ route('mk.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition">



                    Kembali

                </a>

                <button class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow">

                    Simpan Perubahan

                </button>

            </div>
        </form>
        @endsection
    </div>
</div>
