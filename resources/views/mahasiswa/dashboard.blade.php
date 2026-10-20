@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- CARDS -->
<div class="grid md:grid-cols-3 gap-6 mb-6">

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-sm text-gray-500">
            Total Perusahaan
        </p>

        <p class="text-3xl font-bold text-blue-600 mt-2">
            {{ $totalPerusahaan }}
        </p>

        <p class="text-xs text-gray-400 mt-1">
            Perusahaan Magang
        </p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <h3 class="text-gray-500 text-sm">
            Riwayat Rekomendasi
        </h3>

        <p class="text-3xl font-bold text-green-600 mt-2">
            {{ $totalRiwayat }}
        </p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <h3 class="text-gray-500 text-sm">
            User Login
        </h3>

        <p class="text-lg font-bold text-orange-600 mt-2">
            {{ $user->name }}
        </p>
    </div>

</div>



<div class="bg-gradient-to-r from-blue-600 to-blue-500
text-white rounded-2xl shadow-md p-6 mb-6">

    <h1 class="text-3xl font-bold mb-2">
        Selamat Datang, {{ $user->name }}
    </h1>

    <p class="text-blue-100">
        Sistem Rekomendasi Tempat Magang Mahasiswa
        menggunakan metode AHP dan WASPAS.
    </p>

</div>

<div class="grid md:grid-cols-3 gap-4 mb-6">

    <a href="{{ route('profil.index') }}" class="bg-white rounded-xl shadow p-5 hover:shadow-lg">

        <h3 class="font-bold">
            Kompetensi & Minat
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Kelola profil mahasiswa
        </p>

    </a>

    @if($qualificationComplete)

    <a href="{{ route('rekomendasi') }}"
        class="bg-white rounded-xl shadow p-5 hover:shadow-lg transition-all duration-200">

        <h3 class="font-bold">
            Rekomendasi
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Jalankan AHP & WASPAS
        </p>

    </a>

    @else

    <a href="javascript:void(0)" onclick="showQualificationWarning()"
        class="bg-white rounded-xl shadow p-5 cursor-not-allowed opacity-60 transition-all duration-200">

        <div class="flex items-start justify-between">

            <div>
                <h3 class="font-bold text-gray-500">
                    Rekomendasi
                </h3>

                <p class="text-sm text-gray-400 mt-1">
                    Lengkapi kualifikasi terlebih dahulu
                </p>
            </div>

            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center">
                <i class="ri-lock-line text-gray-400 text-lg"></i>
            </div>

        </div>

    </a>

    @endif

    <a href="{{ route('rekomendasi.history') }}" class="bg-white rounded-xl shadow p-5 hover:shadow-lg">

        <h3 class="font-bold">
            History
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Lihat riwayat rekomendasi
        </p>

    </a>

</div>

@if($rekomendasiTerakhir)

<div class="bg-white rounded-2xl shadow-md p-6 mb-6">

    <h2 class="text-xl font-bold mb-4">
        Rekomendasi Terakhir
    </h2>
    <p class="text-sm text-gray-500 mt-3">

        Dibuat pada
        {{ $rekomendasiTerakhir->created_at->format('d M Y H:i') }}

    </p>

    <div class="border rounded-xl p-5">

        <h3 class="text-2xl font-bold text-green-700">
            {{ $rekomendasiTerakhir->industry->nama_industri }}
        </h3>

        <p class="mt-2 text-gray-500">
            Skor Qi:
            <span class="font-bold text-blue-600">
                {{ number_format($rekomendasiTerakhir->qi,4) }}
            </span>
        </p>

        <a href="{{ route('rekomendasi.detailHasil', $rekomendasiTerakhir->id) }}" class="inline-block mt-4 bg-blue-600 text-white
            px-4 py-2 rounded-lg hover:bg-blue-700">

            Lihat Detail

        </a>

    </div>

</div>

@endif
<!-- CHART -->

<script>
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
            label: 'Nilai',
            data: [70, 80, 75, 90],
            borderColor: '#065f46'
        }]
    }
});

new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Web', 'Mobile', 'AI'],
        datasets: [{
            data: [40, 30, 30],
            backgroundColor: ['#065f46', '#34d399', '#a7f3d0']
        }]
    }
});
</script>

@endsection