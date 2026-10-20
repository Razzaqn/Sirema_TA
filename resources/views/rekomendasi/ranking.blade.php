@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md">

    <h2 class="text-xl font-semibold mb-4">Hasil Ranking</h2>
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h3 class="font-semibold text-blue-700 mb-2"> Alasan Rekomendasi</h3>

        <ul class="list-disc pl-5 text-sm text-gray-700">
            @foreach($analisis as $a)
            <li>{{ $a }}</li>
            @endforeach
        </ul>
    </div>
    <table class="w-full text-center border">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-2">Rank</th>
                <th class="p-2">Perusahaan</th>
                <th class="p-2">Qi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($hasil as $h)
            <tr class="border-b">
                <td class="p-2">{{ $h->ranking }}</td>
                <td class="p-2">
                    {{ $h->industry->nama_industri }}
                </td>
                <td class="p-2 text-blue-600 font-semibold">
                    {{ number_format($h->qi, 4) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('rekomendasi.step1') }}"
        class="bg-blue-600 text-white px-3 py-2 rounded mt-5 hover:bg-blue-700 inline-block">
        🔄 Ulang Rekomendasi
    </a>

</div>

@endsection
