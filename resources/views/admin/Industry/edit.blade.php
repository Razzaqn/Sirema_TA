@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto p-6">

    <div class="bg-white rounded-2xl shadow p-8">

        <h1 class="text-2xl font-bold mb-6">
            Edit Perusahaan
        </h1>

        <form action="{{ route('industry.update', $industry->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-5">

                <div>
                    <label class="font-medium">
                        Nama Perusahaan
                    </label>

                    <input type="text" name="nama_industri" value="{{ old('nama_industri', $industry->nama_industri) }}"
                        class="w-full mt-2 rounded-lg border px-4 py-3" required>
                </div>

                <div>
                    <label class="font-medium">
                        Alamat
                    </label>

                    <textarea name="alamat_industri" rows="3" class="w-full mt-2 rounded-lg border px-4 py-3"
                        required>{{ old('alamat_industri', $industry->alamat_industri) }}</textarea>
                </div>

                <div>
                    <label class="font-medium">
                        Kualifikasi Skill
                    </label>

                    <textarea name="kualifikasi_skill" rows="4" class="w-full mt-2 rounded-lg border px-4 py-3"
                        required>{{ old('kualifikasi_skill', $industry->kualifikasi_skill) }}</textarea>
                </div>

                <div>
                    <label class="font-medium">
                        Kuota Magang
                    </label>

                    <input type="number" name="kuota_magang" value="{{ old('kuota_magang', $industry->kuota_magang) }}"
                        min="1" class="w-full mt-2 rounded-lg border px-4 py-3" required>
                </div>
                <div>

                    <label class="font-medium">

                        Wilayah

                    </label>

                    <select name="master_wilayah_id" class="w-full mt-2 rounded-lg border px-4 py-3" required>

                        @foreach($wilayah as $item)

                        <option value="{{ $item->id }}"
                            {{ old('master_wilayah_id', $industry->master_wilayah_id) == $item->id ? 'selected' : '' }}>

                            {{ $item->nama_wilayah }}
                            -
                            {{ $item->provinsi }}

                        </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex justify-end gap-3 mt-8">

                <a href="{{ route('industry.listindustry') }}" class="rounded-lg border px-5 py-3">

                    Batal

                </a>

                <button type="submit" class="rounded-lg bg-blue-600 px-5 py-3 text-white hover:bg-blue-700">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
