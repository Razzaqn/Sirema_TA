@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">

        <span class="inline-flex px-4 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">

            RIWAYAT REKOMENDASI

        </span>

        <h1 class="text-3xl font-bold text-gray-800 mt-4">

            Riwayat Rekomendasi Tempat Magang

        </h1>

        <p class="text-gray-500 mt-3">

            Hasil rekomendasi tempat magang yang Anda lakukan
            menggunakan metode AHP dan WASPAS akan tersimpan di history.

        </p>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-2xl border shadow-sm p-6">

            <p class="text-gray-500 text-sm">

                Total Riwayat

            </p>

            <h2 class="text-4xl font-bold text-blue-600 mt-3">

                {{ $totalRiwayat }}

            </h2>

        </div>

        <div class="bg-white rounded-2xl border shadow-sm p-6">

            <p class="text-gray-500 text-sm">

                Total Perusahaan Dinilai

            </p>

            <h2 class="text-4xl font-bold text-green-600 mt-3">

                {{ $totalPerusahaan }}

            </h2>

        </div>

        <div class="bg-white rounded-2xl border shadow-sm p-6">

            <p class="text-gray-500 text-sm">

                Rekomendasi Terakhir

            </p>

            <h2 class="text-xl font-bold text-orange-500 mt-3">


                {{ $rekomendasiTerakhir?->industry?->nama_industri ?? '-' }}

            </h2>

        </div>

    </div>

    {{-- History List --}}
    <div class="space-y-6">

        @forelse($history as $session)

        @php

        $hasil = $session->hasil
        ->sortBy('ranking')
        ->values();

        if($hasil->isEmpty()){
        continue;
        }

        $terbaik = $hasil->first();

        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-5 border-b bg-gray-50">

                <div class="flex justify-between items-center">

                    <div>

                        <h2 class="font-bold text-xl text-gray-800">

                            Rekomendasi {{ $loop->iteration }}

                        </h2>

                        <p class="text-sm text-gray-500 mt-1">

                            {{ $session->created_at->format('d F Y • H:i') }}

                        </p>

                    </div>

                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">

                        {{ $hasil->count() }} Alternatif

                    </span>

                </div>

            </div>

            {{-- Best Result --}}
            <div class="p-6">

                <div class="flex items-start gap-5">

                    <div class="text-5xl">

                        🥇

                    </div>

                    <div class="flex-1">

                        <p class="text-green-600 font-semibold">

                            Rekomendasi Terbaik

                        </p>

                        <h2 class="text-2xl font-bold mt-1">

                            {{ $terbaik?->industry?->nama_industri ?? '-' }}

                        </h2>

                        <div class="flex gap-3 mt-4">

                            <span class="bg-blue-100 text-blue-700 px-3 py-2 rounded-full text-sm font-semibold">

                                Qi :
                                {{ $terbaik ? number_format($terbaik->qi,4) : '-' }}

                            </span>

                            <span class="bg-green-100 text-green-700 px-3 py-2 rounded-full text-sm font-semibold">

                                CR :
                                {{ number_format($session->cr ?? 0,4) }}

                            </span>

                        </div>

                    </div>

                </div>

                <hr class="my-6">

                <h3 class="font-bold text-lg mb-5">

                    Top Ranking

                </h3>

                <div class="space-y-3">
                    @foreach($hasil as $index => $row)

                    <div class="{{ $index >= 5 ? 'hidden ranking-'.$session->id : '' }}">

                        <div
                            class="flex items-center justify-between rounded-xl border border-gray-200 px-5 py-4 hover:bg-gray-50 transition">

                            <div class="flex items-center gap-4">

                                <div
                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold">

                                    @switch($row->ranking)
                                    @case(1)
                                    🥇
                                    @break

                                    @case(2)
                                    🥈
                                    @break

                                    @case(3)
                                    🥉
                                    @break

                                    @default
                                    {{ $row->ranking }}
                                    @endswitch

                                </div>

                                <div>

                                    <h4 class="font-semibold text-gray-800">

                                        {{ $row->industry?->nama_industri }}

                                    </h4>

                                    <p class="text-sm text-gray-500">

                                        Nilai Qi :
                                        {{ number_format($row->qi,4) }}

                                    </p>

                                </div>

                            </div>

                            <div class="flex items-center gap-3">

                                <span class="font-bold text-blue-600 text-lg">

                                    {{ $row->ranking }}

                                </span>

                                <a href="{{ route('rekomendasi.detailHasil', $row->id) }}" class="inline-flex items-center px-4 py-2 rounded-lg
              bg-blue-600 hover:bg-blue-700
              text-white text-sm font-medium transition">

                                    Detail

                                </a>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

                @if($hasil->count() > 5)

                <div class="mt-6 text-center">

                    <button id="btn-{{ $session->id }}" onclick="toggleRanking({{ $session->id }})"
                        class="px-5 py-2 border border-blue-600 rounded-xl text-blue-600 hover:bg-blue-600 hover:text-white transition">

                        Lihat Semua Ranking

                    </button>

                </div>

                @endif

            </div>

        </div>

        @empty

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">

            <div class="text-6xl">

                📂

            </div>

            <h2 class="text-2xl font-bold text-gray-800 mt-5">

                Belum Ada Riwayat Rekomendasi

            </h2>

            <p class="text-gray-500 mt-2">

                Anda belum pernah melakukan proses rekomendasi tempat magang.

            </p>

        </div>

        @endforelse

    </div>

</div>

<script>
function toggleRanking(id) {

    const rows = document.querySelectorAll('.ranking-' + id);

    const btn = document.getElementById('btn-' + id);

    if (rows.length === 0) return;

    const hidden = rows[0].classList.contains('hidden');

    rows.forEach(function(el) {

        el.classList.toggle('hidden');

    });

    btn.innerHTML = hidden ?
        'Sembunyikan Ranking' :
        'Lihat Semua Ranking';

}
</script>

@endsection