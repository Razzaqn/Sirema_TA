@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md">
    <div class="text-center mb-10">

        <span class="inline-flex bg-green-100 text-green-700 text-xs font-bold px-4 py-2 rounded-full">

            HASIL AKHIR TERHITUNG

        </span>

        <h1 class="text-4xl font-bold mt-4 text-slate-900">

            Rekomendasi Tempat Magang Terbaik

        </h1>

        <p class="text-slate-500 mt-3">

            Berdasarkan pencocokan kriteria AHP dan perhitungan WASPAS,
            berikut perusahaan magang yang paling direkomendasikan
            untuk Anda.

        </p>

    </div>

    {{-- PODIUM --}}
    <div class="bg-[#0F172A] rounded-3xl shadow-xl p-10 mt-8">

        <div class="text-center">

            <h3 class="text-amber-400 font-bold tracking-wide">

                PERINGKAT TERATAS (PODIUM JUARA)

            </h3>

        </div>

        <div class="flex justify-center items-end gap-10 mt-12">

            {{-- SILVER --}}
            @if($top2)

            <div class="text-center w-52">

                <h4 class="text-white font-bold">
                    {{ $top2['industry']->nama_industri }}
                </h4>

                <p class="text-yellow-400 font-semibold mt-1">
                    {{ number_format($top2['qi'] * 100,1) }}% Match
                </p>

                <div class="mt-4 h-40 bg-slate-600 rounded-t-3xl flex flex-col justify-center items-center">

                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center font-bold">

                        2

                    </div>

                    <span class="mt-3 text-white font-bold">

                        SILVER

                    </span>

                </div>

            </div>

            @endif

            {{-- GOLD --}}
            @if($top1)

            <div class="text-center w-56">

                <span class="bg-amber-400 text-slate-900 px-4 py-2 rounded-full text-xs font-bold">

                    REKOMENDASI UTAMA

                </span>

                <h2 class="text-white text-2xl font-bold mt-4">

                    {{ $top1['industry']->nama_industri }}

                </h2>

                <p class="text-yellow-300 font-bold mt-2">

                    {{ number_format($top1['qi'] * 100,1) }}% Match

                </p>

                <div class="mt-4 h-56 bg-amber-500 rounded-t-3xl flex flex-col justify-center items-center">

                    <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center font-bold text-lg">

                        1

                    </div>

                    <span class="mt-4 text-white font-bold">

                        GOLD

                    </span>

                </div>

            </div>

            @endif

            {{-- BRONZE --}}
            @if($top3)

            <div class="text-center w-52">

                <h4 class="text-white font-bold">
                    {{ $top3['industry']->nama_industri }}
                </h4>

                <p class="text-yellow-400 font-semibold mt-1">
                    {{ number_format($top3['qi'] * 100,1) }}% Match
                </p>

                <div class="mt-4 h-36 bg-orange-700 rounded-t-3xl flex flex-col justify-center items-center">

                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center font-bold">

                        3

                    </div>

                    <span class="mt-3 text-white font-bold">

                        BRONZE

                    </span>

                </div>

            </div>

            @endif

        </div>

        @php
        $lainnyaTop = array_slice($lainnya, 0, 2, true);
        $sisanya = array_slice($lainnya, 2, null, true);
        @endphp

        @if(count($lainnyaTop))
        <div class="mt-10 pt-8 border-t border-slate-700/60">
            <div class="flex justify-center gap-4 flex-wrap">
                @foreach($lainnyaTop as $index => $item)
                <div class="bg-slate-800/60 border border-slate-700 rounded-2xl px-5 py-4 flex items-center gap-4 w-72">
                    <div
                        class="w-10 h-10 shrink-0 rounded-full bg-slate-700 text-white font-bold flex items-center justify-center">
                        {{ $index + 4 }}
                    </div>
                    <div class="flex-1 text-left min-w-0">
                        <h4 class="text-white font-semibold text-sm truncate">
                            {{ $item['industry']->nama_industri }}
                        </h4>
                        <p class="text-yellow-400 text-xs font-semibold mt-0.5">
                            {{ number_format($item['qi'] * 100, 1) }}% Match
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <div class="flex gap-3 mb-6 mt-6">

        <button onclick="openDetailModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
            📊 Detail Perhitungan
        </button>

        <button onclick="openNormalisasiModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            📋 Detail Normalisasi
        </button>

        <button onclick="openAlasanModal()" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg">
            💡 Alasan Rekomendasi
        </button>

    </div>

    {{-- TOMBOL TAMPILKAN SEMUA PERINGKAT (peringkat 1-5 sudah ada di podium) --}}
    @if(count($sisanya))
    <div class="flex justify-center mt-10">
        <button onclick="toggleSemuaPeringkat()" id="btnToggleSemua"
            class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-gray-50 transition">
            <span id="labelToggleSemua">Tampilkan Semua Peringkat</span>
            <i class="ri-arrow-down-s-line" id="iconToggleSemua"></i>
        </button>
    </div>

    <div id="semuaPeringkat" class="hidden bg-white rounded-3xl border border-gray-200 shadow-sm mt-4 overflow-hidden">

        <div class="px-8 py-5 bg-gray-50 border-b">
            <h3 class="uppercase tracking-wide text-sm font-bold text-gray-500">
                Peringkat Lainnya
            </h3>
        </div>

        @foreach($sisanya as $index => $item)

        <div class="flex justify-between items-center px-6 py-5 border-b hover:bg-gray-50">

            <div class="flex items-center gap-4">

                <div
                    class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center shadow-sm">

                    {{ $index + 4 }}

                </div>

                <div>

                    <h4 class="font-semibold">

                        {{ $item['industry']->nama_industri }}

                    </h4>

                </div>

            </div>

            <div class="text-right">

                <div class="font-bold text-blue-600">

                    {{ number_format($item['qi']*100,1) }}%

                </div>

                <div class="text-xs text-gray-400">

                    Match

                </div>

            </div>

        </div>

        @endforeach

    </div>
    @endif

    <div class="flex justify-between mt-8">

        <a href="{{ route('rekomendasi') }}"
            class="px-6 py-3 rounded-xl border border-gray-300 text-gray-800 hover:bg-gray-100 transition">
            ← Hitung Ulang
        </a>

        <a href="{{ route('dashboard') }}"
            class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">
            Selesai
        </a>


    </div>

</div>


<!-- MODAL DETAIL PERHITUNGAN -->

<div id="modalDetail" class="hidden fixed inset-0
    bg-black/50 z-50
     items-center justify-center">

    <div class="bg-white rounded-2xl
    shadow-xl w-11/12 max-w-4xl
    max-h-[90vh] overflow-y-auto">

        <!-- Header -->

        <div class="flex justify-between
        items-center p-5 border-b">

            <h2 class="text-xl font-bold">

                📊 Detail Perhitungan WASPAS

            </h2>

            <button onclick="openDetailModal()" class="text-red-500 text-2xl">

                ×

            </button>

        </div>

        <!-- Isi -->

        <div class="p-6">

            <div class="mb-8">

                <h3 class="text-lg font-bold text-slate-800 mb-3">
                    1. Bobot Kriteria (Hasil AHP)
                </h3>

                <table class="w-full border">

                    <thead class="bg-slate-700 text-white">

                        <tr>

                            <th class="p-3 text-left">Kriteria</th>

                            <th class="p-3 text-center">Bobot</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr class="border-b">

                            <td class="p-3">C1 - Kesesuaian Kompetensi</td>

                            <td class="text-center">
                                {{ number_format($bobot['C1'],4) }}
                            </td>

                        </tr>

                        <tr class="border-b">

                            <td class="p-3">C2 - Kesesuaian Minat</td>

                            <td class="text-center">
                                {{ number_format($bobot['C2'],4) }}
                            </td>

                        </tr>

                        <tr class="border-b">

                            <td class="p-3">C3 - Jarak Lokasi</td>

                            <td class="text-center">
                                {{ number_format($bobot['C3'],4) }}
                            </td>

                        </tr>

                        <tr>

                            <td class="p-3">C4 - Biaya Akomodasi</td>

                            <td class="text-center">
                                {{ number_format($bobot['C4'],4) }}
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="mb-8">

                <h3 class="text-lg font-bold text-slate-800 mb-3">
                    2. Matriks Keputusan
                </h3>

                <table class="w-full border">

                    <thead class="bg-blue-600 text-white">

                        <tr>

                            <th class="p-3">Perusahaan</th>

                            <th class="p-3">C1</th>

                            <th class="p-3">C2</th>

                            <th class="p-3">C3</th>

                            <th class="p-3">C4</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($data as $item)

                        <tr class="border-b text-center">

                            <td class="p-3 text-left">
                                {{ $item['industry']->nama_industri }}
                            </td>

                            <td>{{ number_format($item['C1'],2) }}</td>

                            <td>{{ number_format($item['C2'],2) }}</td>

                            <td>{{ number_format($item['C3'],2) }}</td>

                            <td>{{ number_format($item['C4'],2) }}</td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- =========================
3. Matriks Normalisasi
========================= --}}

            <div class="mb-8">

                <h3 class="text-lg font-bold text-slate-800 mb-3">
                    3. Matriks Normalisasi
                </h3>

                <table class="w-full border rounded-lg overflow-hidden">

                    <thead class="bg-indigo-600 text-white">

                        <tr>

                            <th class="p-3">
                                Perusahaan
                            </th>

                            <th class="p-3">
                                C1
                            </th>

                            <th class="p-3">
                                C2
                            </th>

                            <th class="p-3">
                                C3
                            </th>

                            <th class="p-3">
                                C4
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($normal as $industryId => $n)

                        <tr class="border-b text-center">

                            <td class="p-3 text-left">

                                {{ $hasil[$industryId]['industry']->nama_industri }}

                            </td>

                            <td>

                                {{ number_format($n['C1'],4) }}

                            </td>

                            <td>

                                {{ number_format($n['C2'],4) }}

                            </td>

                            <td>

                                {{ number_format($n['C3'],4) }}

                            </td>

                            <td>

                                {{ number_format($n['C4'],4) }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5">

                <h4 class="font-bold text-indigo-700 mb-2">

                    Penjelasan Proses Normalisasi

                </h4>

                <ul class="list-disc pl-5 space-y-2 text-sm text-gray-700">

                    <li>

                        C1 (Kesesuaian Kompetensi) menggunakan atribut
                        <strong>Benefit</strong>.

                    </li>

                    <li>

                        C2 (Kesesuaian Minat) menggunakan atribut
                        <strong>Benefit</strong>.

                    </li>

                    <li>

                        C3 (Jarak Lokasi) menggunakan atribut
                        <strong>Cost</strong>.

                    </li>

                    <li>

                        C4 (Biaya Akomodasi) menggunakan atribut
                        <strong>Cost</strong>.

                    </li>

                </ul>

            </div>

            <div class="mt-5 bg-gray-50 rounded-xl border p-5">

                <h4 class="font-bold mb-3">

                    Rumus Normalisasi

                </h4>

                <div class="space-y-3 text-sm">

                    <div>

                        <strong>Kriteria Benefit</strong>

                        <p class="mt-1">

                            Xij = xij / Max(xj)

                        </p>

                    </div>

                    <div>

                        <strong>Kriteria Cost</strong>

                        <p class="mt-1">

                            Xij = Min(xj) / xij

                        </p>

                    </div>

                </div>

            </div>

            <table class="w-full border">

                <thead class="bg-blue-600 text-white">

                    <tr>

                        <th class="p-3">
                            Perusahaan
                        </th>

                        <th class="p-3">
                            WSM
                        </th>

                        <th class="p-3">
                            WPM
                        </th>

                        <th class="p-3">
                            Qi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil as $h)

                    <tr class="border-b text-center">

                        <td class="p-3">

                            {{
                                $h['industry']
                                ->nama_industri
                            }}

                        </td>

                        <td>

                            {{
                                number_format(
                                    $h['wsm'],
                                    4
                                )
                            }}

                        </td>

                        <td>

                            {{
                                number_format(
                                    $h['wpm'],
                                    4
                                )
                            }}

                        </td>

                        <td class="font-bold text-blue-600">

                            {{
                                number_format(
                                    $h['qi'],
                                    4
                                )
                            }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <hr class="my-8">

            <h3 class="text-xl font-bold mb-5">

                4. Detail Perhitungan WSM

            </h3>

            @foreach($hasil as $h)

            <div class="border rounded-xl p-5 mb-6">

                <h4 class="font-bold text-blue-700 text-lg">

                    {{ $h['industry']->nama_industri }}

                </h4>

                <div class="mt-4 space-y-2">

                    @foreach($h['detail_wsm'] as $item)

                    <div class="flex justify-between">

                        <span>

                            {{ number_format($item['normal'],4) }}

                            ×

                            {{ number_format($item['bobot'],4) }}

                        </span>

                        <span class="font-medium">

                            = {{ number_format($item['hasil'],4) }}

                        </span>

                    </div>

                    @endforeach

                </div>

                <div class="mt-4 border-t pt-3">

                    <span class="font-bold">

                        Total WSM :

                    </span>

                    <span class="text-blue-700 font-bold">

                        {{ number_format($h['wsm'],4) }}

                    </span>

                </div>

            </div>

            @endforeach

            <hr class="my-8">

            <h3 class="text-xl font-bold mb-5">

                5. Detail Perhitungan WPM (Weighted Product Model)

            </h3>

            @foreach($hasil as $h)

            <div class="border rounded-xl p-5 mb-6">

                <h4 class="font-bold text-green-700 text-lg">

                    {{ $h['industry']->nama_industri }}

                </h4>

                <div class="mt-4 space-y-2">

                    @foreach($h['detail_wpm'] as $item)

                    <div class="flex justify-between">

                        <span>

                            {{ number_format($item['normal'],4) }}

                            <sup>{{ number_format($item['bobot'],4) }}</sup>

                        </span>

                        <span>

                            = {{ number_format($item['hasil'],4) }}

                        </span>

                    </div>

                    @endforeach

                </div>

                <div class="mt-4 border-t pt-3">

                    <span class="font-bold">

                        Total WPM :

                    </span>

                    <span class="font-bold text-green-700">

                        {{ number_format($h['wpm'],4) }}

                    </span>

                </div>

            </div>

            @endforeach

            <hr class="my-8">

            <h3 class="text-xl font-bold mb-5">
                6. Detail Perhitungan Nilai Qi
            </h3>

            @foreach($hasil as $h)

            <div class="border rounded-xl p-5 mb-6">

                <h4 class="font-bold text-purple-700 text-lg mb-4">

                    {{ $h['industry']->nama_industri }}

                </h4>

                <table class="w-full border rounded-lg overflow-hidden">

                    <thead class="bg-purple-600 text-white">

                        <tr>

                            <th class="p-3">
                                Komponen
                            </th>

                            <th class="p-3">
                                Nilai
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td class="p-3">
                                0.5 × WSM
                            </td>

                            <td class="text-center">

                                {{ number_format($h['detail_qi']['hasil_wsm'],4) }}

                            </td>

                        </tr>

                        <tr>

                            <td class="p-3">
                                0.5 × WPM
                            </td>

                            <td class="text-center">

                                {{ number_format($h['detail_qi']['hasil_wpm'],4) }}

                            </td>

                        </tr>

                        <tr class="bg-purple-50 font-bold">

                            <td class="p-3">

                                Nilai Qi

                            </td>

                            <td class="text-center text-purple-700">

                                {{ number_format($h['qi'],4) }}

                            </td>

                        </tr>

                    </tbody>

                </table>

                <div class="mt-5 bg-purple-50 rounded-xl p-4 border border-purple-200">

                    <p class="font-semibold mb-2">

                        Substitusi Rumus

                    </p>

                    <p>

                        Qi = (0.5 × {{ number_format($h['wsm'],4) }})
                        +
                        (0.5 × {{ number_format($h['wpm'],4) }})

                    </p>

                    <p class="mt-2 font-bold text-purple-700">

                        = {{ number_format($h['qi'],4) }}

                    </p>

                </div>

            </div>

            @endforeach

            <div class="mt-6 bg-blue-50 p-4 rounded-xl">

                <h3 class="font-bold text-blue-700 mb-2">
                    Rumus Metode WASPAS
                </h3>

                <p>
                    WSM = Σ (wj × xij)
                </p>

                <p>
                    WPM = Π (xij ^ wj)
                </p>

                <p>
                    Qi = 0.5 × WSM + 0.5 × WPM
                </p>

            </div>

        </div>

    </div>

</div>


<!-- MODAL NORMALISASI -->
<div id="modalNormalisasi" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">

    <div class="bg-white rounded-2xl shadow-xl
        w-11/12 max-w-5xl
        max-h-[90vh] overflow-y-auto">

        <!-- Header -->
        <div class="flex justify-between items-center p-5 border-b">

            <h2 class="text-xl font-bold">
                📋 Detail Normalisasi WASPAS
            </h2>

            <button onclick="closeNormalisasiModal()" class="text-red-500 text-2xl">
                ×
            </button>

        </div>

        <!-- Isi -->
        <div class="p-6">

            <table class="w-full border">

                <thead class="bg-blue-600 text-white">

                    <tr>
                        <th class="p-3">Perusahaan</th>
                        <th class="p-3">C1</th>
                        <th class="p-3">C2</th>
                        <th class="p-3">C3</th>
                        <th class="p-3">C4</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($normal as $industryId => $n)

                    <tr class="border-b text-center">

                        <td class="p-3">
                            {{ $hasil[$industryId]['industry']->nama_industri }}
                        </td>

                        <td>
                            {{ number_format($n['C1'],4) }}
                        </td>

                        <td>
                            {{ number_format($n['C2'],4) }}
                        </td>

                        <td>
                            {{ number_format($n['C3'],4) }}
                        </td>

                        <td>
                            {{ number_format($n['C4'],4) }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="mt-5 bg-blue-50 p-4 rounded-xl">

                <h3 class="font-bold text-blue-700 mb-2">
                    Keterangan Normalisasi
                </h3>

                <ul class="list-disc pl-5 text-sm text-gray-700">

                    <li>
                        C1 dan C2 merupakan kriteria benefit (semakin besar semakin baik).
                    </li>

                    <li>
                        C3 dan C4 merupakan kriteria cost (semakin kecil semakin baik).
                    </li>

                    <li>
                        Nilai normalisasi digunakan sebagai dasar perhitungan WSM dan WPM.
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>


<!-- MODAL ALASAN -->

<div id="modalAlasan" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">

    <div class="bg-white rounded-2xl shadow-xl
        w-11/12 max-w-4xl
        max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-center p-5 border-b">

            <h2 class="text-xl font-bold">
                💡 Alasan Rekomendasi
            </h2>

            <button onclick="closeAlasanModal()" class="text-red-500 text-2xl">
                ×
            </button>

        </div>

        <div class="p-6">

            @foreach($hasil as $index => $h)

            <div class="border rounded-xl p-4 mb-4">

                <h3 class="font-bold text-lg text-blue-700">

                    {{ $h['industry']->nama_industri }}

                </h3>

                <div class="mt-2">

                    <span class="bg-green-100
                    text-green-700
                    px-3 py-1
                    rounded-full
                    text-sm">

                        Qi:
                        {{ number_format($h['qi'],4) }}

                    </span>

                </div>

                <ul class="mt-4 list-disc pl-6">

                    @foreach($h['alasan'] as $a)

                    <li>
                        {{ $a }}
                    </li>

                    @endforeach

                </ul>

            </div>

            @endforeach

        </div>

    </div>

</div>



<script>
function toggleSemuaPeringkat() {

    let panel = document.getElementById('semuaPeringkat');
    let label = document.getElementById('labelToggleSemua');
    let icon = document.getElementById('iconToggleSemua');

    let isHidden = panel.classList.contains('hidden');

    panel.classList.toggle('hidden');

    if (isHidden) {
        label.textContent = 'Sembunyikan Peringkat Lainnya';
        icon.classList.remove('ri-arrow-down-s-line');
        icon.classList.add('ri-arrow-up-s-line');
    } else {
        label.textContent = 'Tampilkan Semua Peringkat';
        icon.classList.remove('ri-arrow-up-s-line');
        icon.classList.add('ri-arrow-down-s-line');
    }
}

function openDetailModal() {

    let modal =
        document.getElementById('modalDetail');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDetailModal() {

    let modal =
        document.getElementById('modalDetail');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openNormalisasiModal() {

    let modal =
        document.getElementById('modalNormalisasi');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeNormalisasiModal() {

    let modal =
        document.getElementById('modalNormalisasi');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openAlasanModal() {

    let modal =
        document.getElementById('modalAlasan');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAlasanModal() {

    let modal =
        document.getElementById('modalAlasan');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document
    .getElementById('modalDetail')
    .addEventListener('click', function(e) {

        if (e.target === this) {

            closeDetailModal();
        }

    });

document
    .getElementById('modalNormalisasi')
    .addEventListener('click', function(e) {

        if (e.target === this) {

            closeNormalisasiModal();
        }

    });


document
    .getElementById('modalAlasan')
    .addEventListener('click', function(e) {

        if (e.target === this) {

            closeAlasanModal();
        }

    });
</script>
@endsection
