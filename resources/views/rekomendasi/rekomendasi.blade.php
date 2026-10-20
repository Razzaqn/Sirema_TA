@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Hasil Rekomendasi Magang</h2>

    <!-- CR -->
    <div class="alert alert-info">
        Consistency Ratio (CR): {{ number_format($CR, 3) }}
    </div>

    <!-- Bobot -->
    <h4>Bobot Kriteria</h4>
    <ul>
        @foreach($bobot as $k => $v)
        <li>{{ $k }} : {{ number_format($v, 3) }}</li>
        @endforeach
    </ul>

    <!-- Ranking -->
    <h4 class="mt-4">Ranking Alternatif</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Tempat Magang</th>
                <th>Nilai Qi</th>
            </tr>
        </thead>
        <tbody>
            @php $rank = 1; @endphp
            @foreach($ranking as $alt => $nilai)
            <tr>
                <td>{{ $rank++ }}</td>
                <td>{{ $alt }}</td>
                <td>{{ number_format($nilai, 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
