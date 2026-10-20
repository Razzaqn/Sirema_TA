@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('rekomendasi.history') }}" class="inline-flex items-center gap-2
       bg-blue-700 hover:bg-gray-400
       text-white px-4 py-2 rounded-lg">

            ⬅ Kembali

        </a>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 mt-4">

        <h1 class="text-2xl font-bold mb-2">
            Detail Riwayat Rekomendasi
        </h1>

        <p class="text-gray-500">
            {{
                $rekomendasi->created_at
                ->format('d M Y H:i')
            }}
        </p>

    </div>



    <div class="bg-green-50 border
    rounded-xl p-5 mt-5">

        <h2 class="font-bold text-green-700">
            🥇 Rekomendasi Terbaik
        </h2>

        <p class="text-xl font-semibold mt-2">

            {{
                $terbaik?->industry?->nama_industri
            }}

        </p>

        <p class="mt-2">
            Qi:
            <strong>
                {{
                    number_format(
                        $terbaik->qi,
                        4
                    )
                }}
            </strong>
        </p>

    </div>

    <div class="flex gap-3 mb-6 mt-4">

        <button onclick="openModalAHP()" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            ⚖️ Bobot AHP
        </button>

        <button onclick="openModalNormalisasi()" class="bg-green-600 text-white px-4 py-2 rounded-lg">
            📈 Detail Normalisasi
        </button>

        <button onclick="openModalWaspas()" class="bg-purple-600 text-white px-4 py-2 rounded-lg">
            📊 Detail WASPAS
        </button>

        <button onclick="openModalAlasan()" class="bg-amber-500 text-white px-4 py-2 rounded-lg">
            💡 Alasan Rekomendasi
        </button>

    </div>

    <div class="bg-white rounded-xl
    shadow mt-5">

        <table class="w-full">

            <thead class="bg-blue-600 text-white">

                <tr>
                    <th class="p-3">
                        Ranking
                    </th>

                    <th class="p-3">
                        Perusahaan
                    </th>

                    <th class="p-3">
                        Qi
                    </th>
                </tr>

            </thead>

            <tbody>

                @foreach($hasil as $h)

                <tr class="border-b">

                    <td class="p-3 text-center">
                        {{ $h->ranking }}
                    </td>

                    <td class="p-3">
                        {{
                            $h->industry->nama_industri
                        }}
                    </td>

                    <td class="p-3 text-center font-bold text-blue-600">
                        {{
                            number_format(
                                $h->qi,
                                4
                            )
                        }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>



</div>


<div id="modalAHP" class="hidden fixed inset-0 z-[9999]
    bg-black/50">

    <div class="
        fixed
        top-1/2 left-1/2
        -translate-x-1/2
        -translate-y-1/2
        bg-white
        rounded-2xl
        shadow-xl
        w-11/12
        max-w-3xl
        max-h-[85vh]
        overflow-y-auto
    ">

        <!-- Header -->

        <div class="flex justify-between
        items-center p-5 border-b">

            <h2 class="text-xl font-bold">

                ⚖️ Bobot AHP

            </h2>

            <button onclick="closeModalAHP()" class="text-red-500 text-2xl">

                ×

            </button>

        </div>

        <!-- Body -->

        <div class="p-6">

            <table class="w-full border">

                <thead class="bg-blue-600 text-white">

                    <tr>
                        <th class="p-3">
                            Kriteria
                        </th>

                        <th class="p-3">
                            Bobot
                        </th>
                    </tr>

                </thead>

                <tbody>

                    <tr class="border-b">
                        <td class="p-3">
                            C1 - Kompetensi
                        </td>

                        <td class="text-center">
                            {{ number_format($bobot['C1'] ?? 0,4) }}
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-3">
                            C2 - Minat
                        </td>

                        <td class="text-center">
                            {{ number_format($bobot['C2'] ?? 0,4) }}
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-3">
                            C3 - Jarak
                        </td>

                        <td class="text-center">
                            {{ number_format($bobot['C3'] ?? 0,4) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3">
                            C4 - Biaya
                        </td>

                        <td class="text-center">
                            {{ number_format($bobot['C4'] ?? 0,4) }}
                        </td>
                    </tr>

                </tbody>

            </table>

            <div class="mt-6
            bg-green-50
            border
            rounded-xl
            p-4">

                <h3 class="font-semibold
                text-green-700">

                    Consistency Ratio (CR)

                </h3>

                <div class="text-2xl
                font-bold mt-2">

                    {{ number_format($rekomendasi->cr,4) }}

                </div>

                <div class="mt-2">

                    @if($rekomendasi->cr <= 0.1) <span class="bg-green-100
                        text-green-700
                        px-3 py-1 rounded-full">

                        Konsisten ✅

                        </span>

                        @else

                        <span class="bg-red-100
                        text-red-700
                        px-3 py-1 rounded-full">

                            Tidak Konsisten ❌

                        </span>

                        @endif

                </div>

            </div>

        </div>

    </div>

</div>

<div id="modalAlasan" class="hidden fixed inset-0 bg-black/50 z-[9999]">

    <div class="
        fixed top-1/2 left-1/2
        -translate-x-1/2
        -translate-y-1/2
        bg-white rounded-2xl shadow-xl
        w-11/12 max-w-2xl">

        <div class="flex justify-between items-center p-5 border-b">

            <h2 class="text-xl font-bold">
                💡 Alasan Rekomendasi
            </h2>

            <button onclick="closeModalAlasan()" class="text-red-500 text-2xl">
                ×
            </button>

        </div>

        <div class="p-6">

            <h3 class="text-xl font-bold text-blue-600 mb-3">
                {{ $terbaik->industry->nama_industri }}
            </h3>

            <div class="bg-green-100 text-green-700 px-3 py-2 rounded inline-block mb-4">
                Qi :
                {{ number_format($terbaik->qi,4) }}
            </div>

            <ul class="list-disc pl-5 space-y-2">

                @foreach($alasan as $item)

                <li>{{ $item }}</li>

                @endforeach

            </ul>

        </div>

    </div>

</div>

<div id="modalNormalisasi" class="hidden fixed inset-0 bg-black/50 z-[9999]">

    <div class="
fixed top-1/2 left-1/2
-transform -translate-x-1/2 -translate-y-1/2
bg-white rounded-2xl shadow-xl
w-11/12 max-w-5xl
max-h-[85vh] overflow-y-auto">

        <div class="flex justify-between items-center p-5 border-b">

            <h2 class="text-xl font-bold">
                📈 Detail Normalisasi
            </h2>

            <button onclick="closeModalNormalisasi()" class="text-red-500 text-2xl">
                ×
            </button>

        </div>

        <div class="p-6">

            <table class="w-full border">

                <thead class="bg-green-600 text-white">

                    <tr>
                        <th class="p-3">Perusahaan</th>
                        <th>C1</th>
                        <th>C2</th>
                        <th>C3</th>
                        <th>C4</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil as $h)

                    <tr class="border-b text-center">

                        <td class="p-2">
                            {{ $h->industry->nama_industri }}
                        </td>

                        <td>{{ number_format($h->n_c1,4) }}</td>
                        <td>{{ number_format($h->n_c2,4) }}</td>
                        <td>{{ number_format($h->n_c3,4) }}</td>
                        <td>{{ number_format($h->n_c4,4) }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<div id="modalWaspas" class="hidden fixed inset-0 bg-black/50 z-[9999]">

    <div class="
fixed top-1/2 left-1/2
-transform -translate-x-1/2 -translate-y-1/2
bg-white rounded-2xl shadow-xl
w-11/12 max-w-5xl
max-h-[85vh] overflow-y-auto">

        <div class="flex justify-between items-center p-5 border-b">

            <h2 class="text-xl font-bold">
                📊 Detail Perhitungan WASPAS
            </h2>

            <button onclick="closeModalWaspas()" class="text-red-500 text-2xl">
                ×
            </button>

        </div>

        <div class="p-6">

            <table class="w-full border">

                <thead class="bg-purple-600 text-white">

                    <tr>
                        <th class="p-3">Perusahaan</th>
                        <th>WSM</th>
                        <th>WPM</th>
                        <th>Qi</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil as $h)

                    <tr class="border-b text-center">

                        <td class="p-2">
                            {{ $h->industry->nama_industri }}
                        </td>

                        <td>
                            {{ number_format($h->wsm,4) }}
                        </td>

                        <td>
                            {{ number_format($h->wpm,4) }}
                        </td>

                        <td class="font-bold text-purple-600">
                            {{ number_format($h->qi,4) }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>


<script>
function openModalAHP() {

    document
        .getElementById('modalAHP')
        .classList.remove('hidden');

}

function closeModalAHP() {

    document
        .getElementById('modalAHP')
        .classList.add('hidden');

}

function openModalAlasan() {
    document
        .getElementById('modalAlasan')
        .classList.remove('hidden');
}

function closeModalAlasan() {
    document
        .getElementById('modalAlasan')
        .classList.add('hidden');
}

function openModalNormalisasi() {
    document
        .getElementById('modalNormalisasi')
        .classList.remove('hidden');
}

function closeModalNormalisasi() {
    document
        .getElementById('modalNormalisasi')
        .classList.add('hidden');
}

function openModalWaspas() {
    document
        .getElementById('modalWaspas')
        .classList.remove('hidden');
}

function closeModalWaspas() {
    document
        .getElementById('modalWaspas')
        .classList.add('hidden');
}

document
    .getElementById('modalAHP')
    .addEventListener('click', function(e) {

        if (e.target === this) {

            closeModalAHP();
        }

    });
document
    .getElementById('modalAlasan')
    .addEventListener('click', function(e) {

        if (e.target === this) {

            closeModalAlasan();
        }

    });
document
    .getElementById('modalNormalisasi')
    .addEventListener('click', function(e) {

        if (e.target === this) {

            closeModalNormalsasi();
        }

    });
document
    .getElementById('modalWaspas')
    .addEventListener('click', function(e) {

        if (e.target === this) {

            closeModalWaspas();
        }

    });
</script>

@endsection