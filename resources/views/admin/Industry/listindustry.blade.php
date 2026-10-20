@extends('layouts.admin')

@section('content')
<div>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Perusahaan
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola data perusahaan mitra magang yang digunakan sebagai alternatif
                pada proses rekomendasi SIREMA.
            </p>
        </div>

        <a href="{{ route('industry.create') }}"
            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium shadow-md transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

            </svg>

            Tambah Perusahaan

        </a>

    </div>

    {{-- Alert --}}
    @if(session('success'))

    <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

        </svg>

        {{ session('success') }}

    </div>

    @endif


    {{-- Search --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">

        <div class="relative">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />

            </svg>

            <input id="searchPerusahaan" type="text" placeholder="Cari nama perusahaan..."
                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

        </div>

    </div>


    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

        <div class="w-full overflow-x-auto">

            <table class="w-full table-auto">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                            Nama Perusahaan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                            Alamat
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                            Skill Dibutuhkan
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wide text-gray-700">
                            Kuota
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wide text-gray-700">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($industries as $i)

                    <tr class="border-b hover:bg-blue-50 transition">

                        {{-- Nama --}}
                        <td class="px-6 py-5 align-top">

                            <div class="font-semibold text-gray-800">

                                {{ $i->nama_industri }}

                            </div>

                        </td>

                        {{-- Alamat --}}
                        <td class="px-6 py-5 text-gray-600 w-[35%] break-words">

                            {{ $i->alamat_industri }}

                        </td>

                        {{-- Skill --}}
                        <td class="px-6 py-5">

                            <div class="flex flex-wrap gap-2">

                                @foreach(explode(',', $i->kualifikasi_skill) as $skill)

                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">

                                    {{ trim($skill) }}

                                </span>

                                @endforeach

                            </div>

                        </td>

                        {{-- Kuota --}}
                        <td class="px-6 py-5 text-center">

                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">

                                👥 {{ $i->kuota_magang }}

                            </span>

                        </td>

                        {{-- Action --}}
                        <td class="px-6 py-5">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('industry.edit',$i->id) }}"
                                    class="px-4 py-2 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 transition font-medium">

                                    Edit

                                </a>

                                <form id="delete-form-{{ $i->id }}" action="{{ route('industry.delete',$i->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button" onclick="confirmDelete({{ $i->id }})"
                                        class="px-4 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition font-medium">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center py-10 text-gray-500">

                            Belum ada data perusahaan.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {

    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {

            document.getElementById('delete-form-' + id).submit();

        }

    });

}
</script>
@endpush
