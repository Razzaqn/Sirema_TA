@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">

                Edit Master Wilayah

            </h1>

            <p class="text-gray-500 mt-2">

                Perbarui data wilayah yang digunakan
                sebagai acuan perhitungan C3 dan C4.

            </p>

        </div>

        <a href="{{ route('master-wilayah.index') }}" class="px-5 py-3 rounded-xl bg-gray-200 hover:bg-gray-300">

            ← Kembali

        </a>

    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <form action="{{ route('master-wilayah.update',$masterWilayah->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Nama Wilayah

                </label>

                <input type="text" name="nama_wilayah" value="{{ old('nama_wilayah',$masterWilayah->nama_wilayah) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Provinsi

                </label>

                <input type="text" name="provinsi" value="{{ old('provinsi',$masterWilayah->provinsi) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Jarak dari POLINDRA (KM)

                </label>

                <input type="number" step="0.01" name="jarak_km" value="{{ old('jarak_km',$masterWilayah->jarak_km) }}"
                    class="w-full border rounded-xl px-4 py-3">

                <p class="text-sm text-gray-500 mt-2">

                    Gunakan jarak perjalanan darat dari
                    Politeknik Negeri Indramayu menuju
                    pusat kota/kabupaten berdasarkan Google Maps.

                </p>

            </div>

            <div class="mb-8">

                <label class="block mb-2 font-semibold">

                    Estimasi Biaya Hidup / Bulan

                </label>

                <input type="number" name="estimasi_biaya_hidup"
                    value="{{ old('estimasi_biaya_hidup',$masterWilayah->estimasi_biaya_hidup) }}"
                    class="w-full border rounded-xl px-4 py-3">

                <p class="text-sm text-gray-500 mt-2">

                    Estimasi biaya kos, makan,
                    dan transportasi mahasiswa
                    selama satu bulan.

                </p>

            </div>

            <div class="flex justify-end gap-3">

                <a href="{{ route('master-wilayah.index') }}" class="px-6 py-3 rounded-xl bg-gray-300">

                    Batal

                </a>

                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
