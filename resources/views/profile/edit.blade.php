@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<div class="space-y-6">
    <div class="flex justify-between">

        <a href="{{ route('dashboard') }}"
            class="px-6 py-3 rounded-xl bg-blue-500 text-white hover:bg-blue-700 transition">
            ⬅ Kembali
        </a>

    </div>

    {{-- Nanti Card Profil di sini --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        <div class="grid lg:grid-cols-3 gap-10">

            {{-- FOTO --}}
            <div class="flex flex-col items-center">

                @if($user->photo)

                <img id="preview" src="{{ asset('storage/'.$user->photo) }}"
                    class="w-36 h-36 rounded-full object-cover shadow-lg">

                @else

                <div id="previewContainer"
                    class="w-36 h-36 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white text-5xl font-bold">

                    {{ strtoupper(substr($user->name,0,1)) }}

                </div>

                <img id="preview" class="hidden w-36 h-36 rounded-full object-cover shadow-lg">

                @endif

                <h2 class="mt-5 text-xl font-semibold">

                    {{ $user->name }}

                </h2>

                <p class="text-gray-500">

                    {{ $user->email }}

                </p>

            </div>

            {{-- FORM --}}
            <div class="lg:col-span-2">

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')

                    <div class="grid md:grid-cols-2 gap-5">

                        {{-- Nama --}}
                        <div>

                            <label class="text-sm font-medium text-gray-600">

                                Nama

                            </label>

                            <input type="text" name="name" value="{{ old('name',$user->name) }}"
                                class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        </div>

                        {{-- Email --}}
                        <div>

                            <label class="text-sm font-medium text-gray-600">

                                Email

                            </label>

                            <input type="email" name="email" value="{{ old('email',$user->email) }}"
                                class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        </div>

                    </div>

                    <div class="mt-6">

                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Foto Profil
                        </label>

                        <div class="flex items-center gap-4">

                            <label for="photo"
                                class="cursor-pointer rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 font-medium transition">

                                <i class="ri-image-add-line mr-2"></i>

                                Pilih Foto

                            </label>

                            @if($user->photo)

                            <button type="button" onclick="hapusFoto()"
                                class="rounded-xl bg-red-500 hover:bg-red-600 px-5 py-3 text-white font-medium transition">

                                <i class="ri-delete-bin-line mr-2"></i>

                                Hapus Foto

                            </button>

                            @endif

                            <span id="file-name" class="text-sm text-gray-500">

                                Belum ada file dipilih

                            </span>

                        </div>

                        <input id="photo" type="file" name="photo" accept="image/*" class="hidden">

                    </div>

                    <div class="mt-8 flex justify-end">

                        <button type="submit"
                            class="inline-flex items-center rounded-xl bg-blue-600 px-8 py-3 font-semibold text-white shadow-md transition duration-300 hover:bg-blue-700 hover:shadow-lg">

                            <i class="ri-save-line mr-2"></i>
                            Simpan

                        </button>

                    </div>

                    @if ($errors->any())
                    <div class="mt-4 rounded-xl bg-red-50 border border-red-200 p-4">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                </form>

                @if($user->photo)

                <form id="deletePhotoForm" action="{{ route('profile.photo.delete') }}" method="POST" class="hidden">

                    @csrf
                    @method('DELETE')

                </form>

                @endif

            </div>

        </div>

    </div>



    {{-- Nanti Password di sini --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        <div class="mb-6">

            <h2 class="text-xl font-bold text-gray-800">

                <i class="ri-lock-password-line text-blue-600 mr-2"></i>

                Ubah Password

            </h2>

            <p class="text-sm text-gray-500 mt-1">

                Gunakan password yang kuat agar akun tetap aman.

            </p>

        </div>

        <form action="{{ route('profile.password') }}" method="POST">

            @csrf
            @method('PATCH')

            <div class="grid md:grid-cols-3 gap-5">

                <div>

                    <label class="block text-sm font-medium mb-2">

                        Password Lama

                    </label>

                    <input type="password" name="current_password"
                        class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">

                        Password Baru

                    </label>

                    <input type="password" name="password"
                        class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">

                        Konfirmasi Password

                    </label>

                    <input type="password" name="password_confirmation"
                        class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                </div>

            </div>

            <button class="mt-6 rounded-xl bg-blue-600 hover:bg-blue-700 transition px-8 py-3 text-white font-semibold">

                Ubah Password

            </button>

        </form>

    </div>

</div>

@section('scripts')

<script>
const photoInput = document.getElementById('photo');

const fileName = document.getElementById('file-name');

const preview = document.getElementById('preview');

const previewContainer = document.getElementById('previewContainer');

photoInput.addEventListener('change', function(e) {

    const file = e.target.files[0];

    if (!file) return;

    fileName.textContent = file.name;

    const reader = new FileReader();

    reader.onload = function(event) {

        preview.src = event.target.result;

        preview.classList.remove('hidden');

        if (previewContainer) {

            previewContainer.classList.add('hidden');

        }

    }

    reader.readAsDataURL(file);

});

function hapusFoto() {

    Swal.fire({
        title: 'Hapus Foto Profil?',
        text: 'Foto profil akan dihapus dan avatar akan kembali menggunakan inisial nama.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {
            document.getElementById('deletePhotoForm').submit();
        }

    });

}
</script>

@endsection

@endsection
