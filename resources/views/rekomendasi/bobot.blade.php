@extends('layouts.app')

@section('title', 'Bobot Kriteria')

@section('content')
@php
// Skala jarum gauge: 0 -> -90deg (kiri), 0.10 -> 0deg (puncak, ambang batas), 0.20 -> +90deg (kanan)
$crValue = $CR ?? 0;
$crClamped = min(max($crValue, 0), 0.20);
$needleAngle = -90 + ($crClamped / 0.20) * 180;
$isConsisten = $crValue < 0.1; @endphp <div class="space-y-6">

    <!-- HEADER -->
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="w-2 h-2 rounded-full bg-green-500"></span>
            <span class="text-xs font-mono font-bold tracking-widest uppercase text-green-700">Hasil Perhitungan
                AHP</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Bobot Kriteria</h1>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- CARD BOBOT -->
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6 flex flex-col h-full">
            <div class="flex items-baseline justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-800">Perbandingan Bobot</h2>
                <span class="text-xs text-gray-400">{{ count($bobot ?? []) }} kriteria</span>
            </div>

            <div class="space-y-5 flex-1">
                @foreach($bobot ?? [] as $key => $value)
                <div class="grid grid-cols-[44px_1fr_78px] items-center gap-3">
                    <div class="text-center font-mono font-bold text-xs text-green-700 bg-green-50 rounded-lg py-1.5">
                        C{{ str_replace('C', '', $key) }}
                    </div>
                    <div class="relative h-3.5 bg-gray-100 rounded-full overflow-hidden border border-gray-200">
                        <div class="absolute inset-y-0 left-0 rounded-full bg-gradient-to-r from-green-600 to-green-400 transition-all duration-1000"
                            style="width: {{ round($value * 100, 2) }}%">
                        </div>
                    </div>
                    <div class="text-right font-mono font-bold text-sm text-gray-800">
                        {{ number_format($value, 4) }}
                    </div>
                </div>
                @endforeach
            </div>

            <div
                class="flex justify-between items-center mt-5 pt-4 border-t border-dashed border-gray-200 text-sm text-gray-500">
                <span>Total seluruh bobot</span>
                <span class="font-mono font-bold text-gray-800">{{ number_format(array_sum($bobot ?? []), 4) }}</span>
            </div>
        </div>

        <!-- CARD CR -->
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6 flex flex-col h-full">
            <div class="flex items-baseline justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-800">Uji Konsistensi</h2>
                <span class="text-xs text-gray-400 hidden sm:inline">Menentukan apakah bobot layak dipakai</span>
            </div>

            <!-- GAUGE -->
            <div class="flex flex-col items-center py-1">
                <svg width="240" height="140" viewBox="0 0 260 150">
                    <path d="M 130 130 A 100 100 0 0 1 228.5 65" fill="none" stroke="#FBD5D3" stroke-width="16"
                        stroke-linecap="round" />
                    <path d="M 31.5 65 A 100 100 0 0 1 130 130" fill="none" stroke="#22A06B" stroke-width="16"
                        stroke-linecap="round" opacity="0.9" />
                    <text x="26" y="60" font-family="monospace" font-size="10" fill="#9CA3AF">0.00</text>
                    <text x="120" y="24" font-family="monospace" font-size="10" fill="#9CA3AF">0.10</text>
                    <text x="222" y="60" font-family="monospace" font-size="10" fill="#9CA3AF">0.20</text>
                    <g
                        style="transform-origin:130px 130px; transform: rotate({{ $needleAngle }}deg); transition: transform 1s cubic-bezier(.16,.84,.32,1);">
                        <line x1="130" y1="130" x2="130" y2="45" stroke="#374151" stroke-width="3"
                            stroke-linecap="round" />
                    </g>
                    <circle cx="130" cy="130" r="7" fill="#374151" />
                    <circle cx="130" cy="130" r="3" fill="#2563EB" />
                </svg>

                <div class="text-center -mt-1">
                    <div class="text-[11px] uppercase tracking-widest text-gray-400 font-semibold">Consistency Ratio
                    </div>
                    <div
                        class="font-mono font-bold text-3xl {{ $isConsisten ? 'text-green-600' : 'text-red-600' }} my-1">
                        {{ number_format($crValue, 4) }}
                    </div>

                    @if($isConsisten)
                    <span
                        class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-sm font-bold">
                        <i class="ri-checkbox-circle-fill"></i>
                        Konsisten (Dapat digunakan)
                    </span>
                    <div class="text-xs text-gray-400 mt-2">CR berada di bawah ambang batas 0.10</div>
                    @else
                    <span
                        class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-1.5 rounded-full text-sm font-bold">
                        <i class="ri-close-circle-fill"></i>
                        Tidak Konsisten (Ulangi input AHP)
                    </span>
                    <div class="text-xs text-gray-400 mt-2">CR melebihi ambang batas 0.10</div>
                    @endif
                </div>
            </div>

            <!-- STAT STRIP -->
            <div class="grid grid-cols-3 gap-3 mt-6">
                <div class="bg-gray-50 border border-gray-200 rounded-xl text-center py-3">
                    <div class="text-[10px] uppercase tracking-wide text-gray-400 font-semibold">λ maks</div>
                    <div class="font-mono font-bold text-blue-600 text-base mt-1">{{ number_format($lambdaMax, 4) }}
                    </div>
                    <div class="text-[10px] text-gray-400 mt-0.5">Lambda Max</div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl text-center py-3">
                    <div class="text-[10px] uppercase tracking-wide text-gray-400 font-semibold">CI</div>
                    <div class="font-mono font-bold text-purple-600 text-base mt-1">{{ number_format($CI, 4) }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">Consistency Index</div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl text-center py-3">
                    <div class="text-[10px] uppercase tracking-wide text-gray-400 font-semibold">CR</div>
                    <div
                        class="font-mono font-bold text-base mt-1 {{ $isConsisten ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($crValue, 4) }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">Consistency Ratio</div>
                </div>
            </div>

            <!-- SARAN PERBAIKAN kalau tidak konsisten -->
            @if(!$isConsisten)
            <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4">
                <h3 class="flex items-center gap-2 font-bold text-red-600 mb-2 text-sm">
                    <i class="ri-error-warning-line"></i> Penilaian Belum Konsisten
                </h3>
                <p class="text-sm text-gray-700">
                    Nilai <strong class="font-mono">CR = {{ number_format($crValue, 4) }}</strong>
                    melebihi batas maksimum <strong>0.1</strong>.
                </p>
                <div class="mt-3 text-sm text-gray-700">
                    <p class="font-semibold mb-2">Saran perbaikan:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Kurangi pilihan ekstrem.</li>
                        <li>Gunakan nilai lebih seimbang.</li>
                        <li>Coba pilih "Sama Penting" jika ragu.</li>
                    </ul>
                </div>
            </div>
            @endif

            <button onclick="modalAHP()"
                class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
                <i class="ri-bar-chart-2-line"></i> Lihat Detail Perhitungan
            </button>
        </div>

    </div>

    <!-- AKSI -->
    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('rekomendasi') }}"
            class="flex items-center justify-center gap-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold text-sm px-5 py-3 rounded-xl transition">
            <i class="ri-arrow-left-line"></i> Kembali Input
        </a>

        @if($crValue <= 0.1) <a href="{{ route('rekomendasi.waspas') }}"
            class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-3 rounded-xl transition shadow-sm">
            Lihat Hasil Rekomendasi <i class="ri-arrow-right-line"></i>
            </a>
            @endif
    </div>

    </div>

    <!-- MODAL DETAIL PERHITUNGAN -->
    <div id="modalAHP"
        class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">

        <div class="bg-white w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-[28px] relative">

            <div
                class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between z-10 rounded-t-[28px]">
                <h2 class="text-lg font-bold text-gray-800">Detail Perhitungan AHP</h2>
                <button id="btnClose"
                    class="w-9 h-9 flex items-center justify-center rounded-full text-gray-400 hover:text-white hover:bg-red-500 transition text-lg">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div class="p-6 space-y-8 text-sm text-gray-700">

                <!-- 1. Matriks Perbandingan -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">1</span>
                        <h3 class="font-bold text-gray-800">Matriks Perbandingan Berpasangan</h3>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full text-center">
                            <thead class="bg-blue-600 text-white">
                                <tr>
                                    <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide">Kriteria</th>
                                    @foreach(array_keys($matriks) as $kriteria)
                                    <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide">{{ $kriteria }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($matriks as $baris => $kolom)
                                <tr>
                                    <th class="bg-gray-50 px-4 py-2 font-semibold text-gray-700">{{ $baris }}</th>
                                    @foreach($kolom as $nilai)
                                    <td class="px-4 py-2 font-mono">
                                        {{ rtrim(rtrim(number_format($nilai, 3), '0'), '.') }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                                <tr class="bg-blue-50 font-semibold">
                                    <td class="px-4 py-2">Jumlah</td>
                                    @foreach($jumlahKolom as $jumlah)
                                    <td class="px-4 py-2 font-mono">
                                        {{ rtrim(rtrim(number_format($jumlah, 3), '0'), '.') }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Matriks Normalisasi -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="w-6 h-6 flex items-center justify-center rounded-full bg-green-600 text-white text-xs font-bold">2</span>
                        <h3 class="font-bold text-gray-800">Matriks Normalisasi</h3>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full text-center">
                            <thead class="bg-green-600 text-white">
                                <tr>
                                    <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide">Kriteria</th>
                                    @foreach(array_keys($normalisasi) as $kriteria)
                                    <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide">{{ $kriteria }}
                                    </th>
                                    @endforeach
                                    <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide">Bobot</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($normalisasi as $baris => $kolom)
                                <tr>
                                    <th class="bg-gray-50 px-4 py-2 font-semibold text-gray-700">{{ $baris }}</th>
                                    @foreach($kolom as $nilai)
                                    <td class="px-4 py-2 font-mono">
                                        {{ rtrim(rtrim(number_format($nilai, 3), '0'), '.') }}</td>
                                    @endforeach
                                    <td class="px-4 py-2 font-mono font-bold text-green-600">
                                        {{ number_format($bobot[$baris], 4) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3. Perkalian Matriks x Bobot -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">3</span>
                        <h3 class="font-bold text-gray-800">Perkalian Matriks × Bobot</h3>
                    </div>
                    @if(!empty($detailPerhitungan))
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-1.5 font-mono text-xs">
                        @foreach($detailPerhitungan as $sd)
                        <p>{{ $loop->iteration }} = {!! $sd['rumus'] !!} = <b>{{ number_format($sd['hasil'], 4) }}</b>
                        </p>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- 4. Nilai Lambda -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">4</span>
                        <h3 class="font-bold text-gray-800">Nilai Lambda</h3>
                    </div>
                    @php $dl = $detailLambda ?? []; @endphp
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-1.5 font-mono text-xs">
                        @foreach($detailPerhitungan ?? [] as $i => $d)
                        <p>λ{{ $loop->iteration }} = {{ number_format($d['hasil'], 4) }} /
                            {{ number_format($bobot[$i], 4) }} = <b>{{ number_format($d['lambda'], 4) }}</b></p>
                        @endforeach
                    </div>

                    <p class="mt-3 text-sm">
                        <strong>Rata-rata (λmax):</strong><br>
                        <span class="font-mono text-xs">
                            = ( @foreach($dl as $l){{ number_format($l, 4) }}{{ !$loop->last ? ' + ' : '' }}@endforeach
                            ) / {{ count($dl) }}<br>
                            = {{ number_format($totalLambda ?? 0, 4) }} / {{ count($dl) }}<br>
                            = <b class="text-blue-600">{{ number_format($lambdaMax ?? 0, 4) }}</b>
                        </span>
                    </p>
                </div>

                <!-- 5-7. Lambda Max, CI, CR -->
                <div class="grid gap-4">
                    <div class="flex items-start gap-2">
                        <span
                            class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold shrink-0 mt-0.5">5</span>
                        <p>λmax = <b class="font-mono text-blue-600">{{ number_format($lambdaMax, 4) }}</b></p>
                    </div>

                    <div class="flex items-start gap-2">
                        <span
                            class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold shrink-0 mt-0.5">6</span>
                        <p class="font-mono text-xs">
                            CI = ({{ number_format($lambdaMax, 4) }} − {{ count($bobot) }}) / {{ count($bobot) - 1 }}
                            = <b class="text-purple-600">{{ number_format($CI, 4) }}</b>
                        </p>
                    </div>

                    @php
                    $riTable = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.90, 5 => 1.12];
                    $ri = $riTable[count($bobot)] ?? 1.12;
                    @endphp
                    <div class="flex items-start gap-2">
                        <span
                            class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold shrink-0 mt-0.5">7</span>
                        <p class="font-mono text-xs">
                            CR = {{ number_format($CI, 4) }} / {{ number_format($ri, 2) }}
                            = <b
                                class="{{ $isConsisten ? 'text-green-600' : 'text-red-600' }}">{{ number_format($CR, 4) }}</b>
                        </p>
                    </div>
                </div>

                @if($isConsisten)
                <div class="flex items-center gap-2 bg-green-100 text-green-700 rounded-xl p-3 text-sm font-semibold">
                    <i class="ri-checkbox-circle-fill"></i> Matriks konsisten, hasil dapat digunakan.
                </div>
                @else
                <div class="flex items-center gap-2 bg-red-100 text-red-700 rounded-xl p-3 text-sm font-semibold">
                    <i class="ri-close-circle-fill"></i> Matriks tidak konsisten, silakan ulangi input.
                </div>
                @endif

            </div>
        </div>
    </div>

    <script>
    function modalAHP() {
        document.getElementById('modalAHP').classList.remove('hidden');
        document.getElementById('modalAHP').classList.add('flex');
    }

    document.getElementById('modalAHP').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
            this.classList.remove('flex');
        }
    });

    document.getElementById('btnClose').onclick = function() {
        document.getElementById('modalAHP').classList.add('hidden');
        document.getElementById('modalAHP').classList.remove('flex');
    };
    </script>
    @endsection
