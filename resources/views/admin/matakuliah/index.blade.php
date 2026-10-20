@extends('layouts.admin')

@section('content')
<div class="flex items-center gap-2 text-sm text-gray-500 mb-6">

    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">

        Dashboard

    </a>

    <span>/</span>

    <a href="{{ route('mk.index') }}" class="hover:text-blue-600">

        Mata Kuliah

    </a>

</div>
<div class="bg-white p-6 rounded-xl shadow-md">


    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">

                Data Mata Kuliah

            </h1>

            <p class="text-gray-500 mt-2">

                Kelola data mata kuliah sebagai dasar perhitungan profil kompetensi mahasiswa.

            </p>

        </div>

        <a href="{{ route('mk.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow hover:shadow-lg transition">

            + Tambah Mata Kuliah

        </a>

    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded-lg overflow-hidden">

            <thead class="bg-gray-100 text-gray-700  uppercase tracking-wide text-xs">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Bidang</th>
                    <th class="p-3 text-left">Semester</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $mk)
                <tr class="border-t hover:bg-blue-50">
                    <td class="p-3">{{ $mk->nama }}</td>
                    <td class="p-3">

                        <div class="flex flex-wrap gap-2">

                            @forelse($mk->bidangKompetensi as $mapping)

                            <span class="inline-flex items-center px-3 py-1
                         rounded-full bg-blue-100 text-blue-700
                         text-xs font-semibold">

                                {{ $mapping->bidang }}

                            </span>

                            @empty

                            <span class="text-gray-400 text-sm">
                                Belum dipetakan
                            </span>

                            @endforelse

                        </div>

                    </td>
                    <td class="p-3">Semester {{ $mk->semester }}</td>
                    <td class="p-3 text-center space-x-2">

                        <a href="{{ route('mk.edit', $mk->id) }}"
                            class="bg-yellow-400 text-white px-3 py-1 rounded-lg shadow-sm hover:bg-yellow-500 hover:scale-105">
                            Edit
                        </a>

                        <form id="deleteForm" method="POST" class="inline">
                            @csrf
                            @method('DELETE')

                            <button type="button" onclick="openDeleteModal('{{ $mk->id }}')"
                                class="bg-red-500 text-white px-3 py-1 rounded-lg shadow-sm hover:bg-red-600 hover:scale-10">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center p-4 text-gray-500">
                        Belum ada data
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg p-6 w-96">

        <h2 class="text-lg font-semibold mb-2">Hapus Data</h2>
        <p class="text-gray-600 mb-4">Apakah kamu yakin ingin menghapus data ini?</p>

        <div class="flex justify-end space-x-2">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </button>

            <button onclick="submitDelete()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Hapus
            </button>
        </div>

    </div>

</div>
<script>
let deleteId = null;

function openDeleteModal(id) {
    deleteId = id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function submitDelete() {
    const form = document.getElementById('deleteForm');
    form.action = '/admin/matakuliah/delete/' + deleteId;
    form.submit();
}
</script>
@endsection
