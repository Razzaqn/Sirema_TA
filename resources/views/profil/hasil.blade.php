@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md w-full max-w-xl">

    <h2 class="text-xl font-semibold mb-4">Hasil Profil Kompetensi</h2>

    <table class="w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Bidang</th>
                <th class="p-2 text-left">Nilai</th>
            </tr>
        </thead>

        <tbody>
            @foreach($nilaiBidang as $bidang => $nilai)
            <tr class="border-t">
                <td class="p-2">{{ ucfirst($bidang) }}</td>
                <td class="p-2 font-semibold">{{ round($nilai,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 p-3 bg-blue-100 rounded">
        <strong>Bidang Dominan:</strong> {{ ucfirst($dominan) }}
    </div>

</div>
@endsection
