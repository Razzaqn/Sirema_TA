@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">

        <div class="flex">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />

            </svg>

            <div>

                <p class="font-semibold text-blue-700">

                    Informasi

                </p>

                <p class="text-sm text-blue-600 mt-1">

                    Data wilayah digunakan sebagai acuan otomatis
                    dalam perhitungan
                    <b>C3 (Jarak Lokasi Magang)</b>
                    dan
                    <b>C4 (Estimasi Biaya Hidup)</b>
                    pada proses rekomendasi.

                </p>

            </div>

        </div>

    </div>

    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow-md p-6 mb-6 flex justify-between items-center">


        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                🌍 Master Wilayah
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola data wilayah sebagai acuan jarak lokasi magang (C3)
                dan estimasi biaya hidup (C4).
            </p>
        </div>

        <a href="{{ route('master-wilayah.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow transition">

            + Tambah Wilayah

        </a>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-5">

        {{ session('success') }}

    </div>

    @endif

    @if(session('error'))

    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-5">

        {{ session('error') }}

    </div>

    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-6 py-4 text-left">No</th>

                    <th class="px-6 py-4 text-left">
                        Wilayah
                    </th>

                    <th class="px-6 py-4 text-left">
                        Provinsi
                    </th>

                    <th class="px-6 py-4 text-center">
                        Jarak (KM)
                    </th>

                    <th class="px-6 py-4 text-center">
                        Estimasi Biaya Hidup
                    </th>

                    <th class="px-6 py-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($wilayah as $item)

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-6 py-4">
                        {{ $loop->iteration + ($wilayah->firstItem() ?? 0) - 1 }}
                    </td>

                    <td class="px-6 py-4 font-semibold">

                        {{ $item->nama_wilayah }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $item->provinsi }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        {{ $item->jarak_km }} km

                    </td>

                    <td class="px-6 py-4 text-center">

                        Rp {{ number_format($item->estimasi_biaya_hidup,0,',','.') }}

                    </td>

                    <td class="px-6 py-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('master-wilayah.edit',$item->id) }}"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg">

                                Edit

                            </a>

                            <form action="{{ route('master-wilayah.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus wilayah ini?')">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                                    Hapus

                                </button>



                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center py-10 text-gray-400">

                        Belum ada data wilayah.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-5">

        {{ $wilayah->links() }}

    </div>

</div>

@endsection
