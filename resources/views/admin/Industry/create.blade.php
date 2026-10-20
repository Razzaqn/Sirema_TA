@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl">

    <h1 class="text-2xl font-bold mb-6">Tambah Perusahaan</h1>

    <div class="bg-white p-6 rounded-xl shadow">

        <form method="POST" action="{{ route('industry.store') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Nama Perusahaan</label>
                <input type="text" name="nama_industri"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">

                @error('nama_industri')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Alamat</label>
                <textarea name="alamat_industri"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></textarea>

                @error('alamat_industri')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Skill -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Skill Dibutuhkan</label>
                <textarea name="kualifikasi_skill"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></textarea>

                @error('kualifikasi_skill')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mt-4">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Kuota Magang
                </label>

                <input type="number" name="kuota_magang" min="1" value="1"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    required>

                <p class="text-xs text-gray-500 mt-1">
                    Jumlah maksimal mahasiswa yang dapat diterima oleh perusahaan.
                </p>
            </div>

            <!-- Jarak & Estimasi biaya -->
            <div class="mb-4">
                <div class="mt-4">

                    <label class="block mb-2 text-sm font-semibold text-gray-700">

                        Wilayah

                    </label>

                    <select name="master_wilayah_id" class="w-full rounded-lg border border-gray-300 px-4 py-3"
                        required>

                        <option value="">-- Pilih Wilayah --</option>

                        @foreach($wilayah as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_wilayah }} - {{ $item->provinsi }}
                        </option>
                        @endforeach

                    </select>

                    <p class="text-xs text-gray-500 mt-2">

                        Jarak lokasi dan estimasi biaya hidup akan
                        diambil otomatis dari Master Wilayah.

                    </p>

                </div>
            </div>



            <!-- Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
