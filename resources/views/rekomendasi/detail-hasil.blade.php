@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">
    <div class="mb-5 text-sm text-gray-500">

        <a href="{{ route('rekomendasi.history') }}" class="hover:text-blue-600">

            History

        </a>

        /

        <span class="font-semibold">
            Detail Hasil
        </span>

    </div>
    <div class="mb-4">
        <a href="{{ route('rekomendasi.history') }}" class="inline-flex items-center gap-2
       bg-blue-700 hover:bg-gray-400
       text-white px-4 py-2 rounded-lg">

            ⬅ Kembali

        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">

        <h1 class="text-3xl font-bold">

            Detail Hasil Rekomendasi

        </h1>

        <p class="text-gray-500 mt-2">

            Informasi lengkap hasil perhitungan perusahaan.

        </p>

    </div>

    <div class="bg-gradient-to-r bg-white from-green-50 to-green-100
            rounded-2xl shadow-md p-8 mb-6">

        <h2 class="text-3xl font-bold text-green-700 mb-2">
            {{ $hasil->industry->nama_industri }}
        </h2>
        @if($hasil->ranking == 1)

        <div class="mt-3">

            <span class="bg-yellow-100
                 text-yellow-700
                 px-4 py-2
                 rounded-full
                 font-semibold">

                🏆 Rekomendasi Terbaik

            </span>

        </div>

        @endif

        <p class="text-gray-600">
            Detail hasil rekomendasi berdasarkan metode
            AHP dan WASPAS
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

            <div class="bg-blue-50 rounded-xl p-5 shadow-sm">
                <p class="text-gray-500 text-sm">
                    Ranking
                </p>

                <p class=" text-4xl font-bold text-orange-500">
                    {{ $hasil->ranking }}
                </p>
            </div>

            <div class="bg-blue-50 rounded-xl p-5 shadow-sm">
                <p class="text-gray-500 text-sm">
                    Skor Qi
                </p>

                <p class="text-4xl font-bold text-blue-600">
                    {{ number_format($hasil->qi,4) }}
                </p>
            </div>

            <div class="bg-blue-50 rounded-xl p-5 shadow-sm">
                <p class="text-gray-500 text-sm">
                    Consistency Ratio
                </p>

                <p class="text-4xl font-bold text-green-600">
                    {{ number_format($cr,4) }}
                </p>

                <span class="inline-block mt-2
                bg-green-100 text-green-900
                px-3 py-1 rounded-full text-xs">

                    Konsisten ✓

                </span>
            </div>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">

        <h3 class="text-xl font-bold mb-5">
            Nilai Normalisasi
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            <!-- C1 -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">

                <p class="text-sm text-gray-500">
                    C1 - Kompetensi
                </p>

                <h4 class="text-3xl font-bold text-blue-600 mt-3">
                    {{ number_format($hasil->n_c1, 4) }}
                </h4>

                <p class="text-sm text-gray-600 mt-2">
                    Nilai kompetensi setelah normalisasi
                </p>

            </div>

            <!-- C2 -->
            <div class="bg-green-50 border border-green-100 rounded-xl p-5">

                <p class="text-sm text-gray-500">
                    C2 - Minat
                </p>

                <h4 class="text-3xl font-bold text-green-600 mt-3">
                    {{ number_format($hasil->n_c2, 4) }}
                </h4>

                <p class="text-sm text-gray-600 mt-2">
                    Tingkat kesesuaian minat mahasiswa
                </p>

            </div>

            <!-- C3 -->
            <div class="bg-orange-50 border border-orange-100 rounded-xl p-5">

                <p class="text-sm text-gray-500">
                    C3 - Jarak
                </p>

                <h4 class="text-3xl font-bold text-orange-600 mt-3">
                    {{ number_format($hasil->n_c3, 4) }}
                </h4>

                <p class="text-sm text-gray-600 mt-2">
                    Nilai normalisasi kriteria jarak
                </p>

            </div>

            <!-- C4 -->
            <div class="bg-purple-50 border border-purple-100 rounded-xl p-5">

                <p class="text-sm text-gray-500">
                    C4 - Biaya
                </p>

                <h4 class="text-3xl font-bold text-purple-600 mt-3">
                    {{ number_format($hasil->n_c4, 4) }}
                </h4>

                <p class="text-sm text-gray-600 mt-2">
                    Nilai normalisasi biaya akomodasi
                </p>

            </div>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">

        <h3 class="text-xl font-bold mb-5">
            ⚖️ Bobot Kriteria AHP
        </h3>

        @php
        $labels = [
        'C1' => 'Kompetensi',
        'C2' => 'Minat',
        'C3' => 'Jarak',
        'C4' => 'Biaya'
        ];

        $maxBobot = max($bobot);
        @endphp

        <div class="space-y-5">

            @foreach($bobot as $kode => $nilai)

            <div>

                <div class="flex justify-between mb-2">

                    <span class="font-medium">
                        {{ $kode }} - {{ $labels[$kode] }}
                    </span>

                    <span class="font-bold text-blue-600">
                        {{ number_format($nilai * 100, 2) }}%
                        <span class="text-gray-500 font-normal">
                            ({{ number_format($nilai, 4) }})
                        </span>
                    </span>

                </div>

                @php
                $persen = $nilai * 100;
                @endphp

                <div class="w-full bg-gray-200 rounded-full h-4">

                    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $persen }}%">
                    </div>

                </div>



            </div>

            @endforeach

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">

        <h3 class="text-xl font-bold mb-5">
            Perhitungan WASPAS
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <!-- WSM -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">

                <p class="text-sm text-gray-500">
                    Weighted Sum Model (WSM)
                </p>

                <h4 class="text-3xl font-bold text-blue-600 mt-3">
                    {{ number_format($hasil->wsm, 4) }}
                </h4>

                <p class="text-sm text-gray-600 mt-2">
                    Hasil penjumlahan terbobot
                </p>

            </div>

            <!-- WPM -->
            <div class="bg-green-50 border border-green-100 rounded-xl p-5">

                <p class="text-sm text-gray-500">
                    Weighted Product Model (WPM)
                </p>

                <h4 class="text-3xl font-bold text-green-600 mt-3">
                    {{ number_format($hasil->wpm, 4) }}
                </h4>

                <p class="text-sm text-gray-600 mt-2">
                    Hasil perkalian terbobot
                </p>

            </div>

            <!-- Qi -->
            <div class="bg-purple-50 border border-purple-100 rounded-xl p-5">

                <p class="text-sm text-gray-500">
                    Nilai Akhir (Qi)
                </p>

                <h4 class="text-3xl font-bold text-purple-600 mt-3">
                    {{ number_format($hasil->qi, 4) }}
                </h4>

                <p class="text-sm text-gray-600 mt-2">
                    Nilai akhir metode WASPAS
                </p>

            </div>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">

        <h3 class="text-xl font-bold mb-5">
            Alasan Rekomendasi
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            @if($hasil->n_c1 >= 0.8)

            <div class="bg-green-50 border border-green-100 rounded-xl p-4">

                <p class="font-bold text-green-700">
                    Kompetensi
                </p>

                <p class="text-sm text-gray-600 mt-2">
                    Kompetensi mahasiswa sangat sesuai dengan kebutuhan perusahaan.
                </p>

            </div>

            @endif

            @if($hasil->n_c2 >= 0.8)

            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">

                <p class="font-bold text-blue-700">
                    Minat Mahasiswa
                </p>

                <p class="text-sm text-gray-600 mt-2">
                    Bidang minat mahasiswa sesuai dengan perusahaan.
                </p>

            </div>

            @endif

            @if($hasil->n_c3 >= 0.8)

            <div class="bg-orange-50 border border-orange-100 rounded-xl p-4">

                <p class="font-bold text-orange-700">
                    Jarak Lokasi
                </p>

                <p class="text-sm text-gray-600 mt-2">
                    Lokasi magang relatif dekat dibanding alternatif lainnya.
                </p>

            </div>

            @endif

            @if($hasil->n_c4 >= 0.8)

            <div class="bg-purple-50 border border-purple-100 rounded-xl p-4">

                <p class="font-bold text-purple-700">
                    Biaya Akomodasi
                </p>

                <p class="text-sm text-gray-600 mt-2">
                    Biaya akomodasi dan kehidupan relatif rendah.
                </p>

            </div>

            @endif

        </div>

        <div class="mt-5 bg-yellow-50 border border-yellow-100 rounded-xl p-5">

            <p class="font-bold text-yellow-700">
                Kesimpulan
            </p>

            <p class="text-gray-700 mt-2">
                Perusahaan ini memperoleh nilai akhir (Qi)
                sebesar
                <strong>{{ number_format($hasil->qi,4) }}</strong>
                sehingga menempati
                <strong>peringkat {{ $hasil->ranking }}</strong>
                berdasarkan perhitungan metode AHP dan WASPAS.
            </p>

        </div>

    </div>

</div>

@endsection
