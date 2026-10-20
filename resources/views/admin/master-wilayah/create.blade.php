@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Tambah Master Wilayah
            </h1>

            <p class="text-gray-500 mt-2">
                Tambahkan data wilayah sebagai acuan perhitungan
                jarak lokasi (C3) dan estimasi biaya hidup (C4).
            </p>

        </div>

        <a href="{{ route('master-wilayah.index') }}"
            class="px-5 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 transition">

            ← Kembali

        </a>

    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <form action="{{ route('master-wilayah.store') }}" method="POST">

            @csrf

            {{-- Nama Wilayah --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Nama Wilayah
                </label>

                <input type="text" name="nama_wilayah" value="{{ old('nama_wilayah') }}"
                    class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200"
                    placeholder="Contoh : Bandung">

                @error('nama_wilayah')

                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>

                @enderror

            </div>

            {{-- Provinsi --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Provinsi

                </label>

                <input type="text" name="provinsi" value="{{ old('provinsi') }}"
                    class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200"
                    placeholder="Contoh : Jawa Barat">

                @error('provinsi')

                <p class="text-red-500 text-sm mt-1">

                    {{ $message }}

                </p>

                @enderror

            </div>

            {{-- Jarak --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Jarak dari POLINDRA (KM)

                </label>

                <input type="number" step="0.01" min="0" name="jarak_km" value="{{ old('jarak_km') }}"
                    class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200"
                    placeholder="Contoh : 160">

                <p class="text-sm text-gray-500 mt-2">

                    Gunakan jarak perjalanan darat berdasarkan Google Maps
                    dari Politeknik Negeri Indramayu menuju pusat kota/kabupaten.

                </p>

                @error('jarak_km')

                <p class="text-red-500 text-sm mt-1">

                    {{ $message }}

                </p>


                @enderror

            </div>

            {{-- Estimasi Biaya --}}
            <div class="mb-8">

                <label class="block mb-2 font-semibold">

                    Estimasi Biaya Hidup / Bulan

                </label>

                <input type="number" min="0" name="estimasi_biaya_hidup" value="{{ old('estimasi_biaya_hidup') }}"
                    class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200"
                    placeholder="Contoh : 2500000">

                <p class="text-sm text-gray-500 mt-2">

                    Estimasi biaya hidup merupakan perkiraan total biaya
                    kos, makan, dan transportasi mahasiswa
                    selama satu bulan pada wilayah tersebut.

                </p>

                @error('estimasi_biaya_hidup')

                <p class="text-red-500 text-sm mt-1">

                    {{ $message }}

                </p>

                @enderror

            </div>

            {{-- Button --}}
            <div class="flex justify-end gap-3">

                <a href="{{ route('master-wilayah.index') }}"
                    class="px-6 py-3 rounded-xl bg-gray-300 hover:bg-gray-400">

                    Batal

                </a>

                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">

                    Simpan Wilayah

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
