<div id="content-upload" class="hidden">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <h2 class="text-xl font-bold text-slate-800 mb-6">
            Upload Bukti Diterima Magang
        </h2>

        @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('industry.upload-bukti') }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">

            @csrf

            @if($holdAktif->count())

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">

                <div class="flex justify-between items-center">

                    <!-- Kiri -->
                    <div class="w-full">

                        <p class="text-sm text-slate-500">
                            Perusahaan Yang Sedang Di-Hold
                        </p>

                        <div class="space-y-3 mt-3">

                            @foreach($holdAktif as $hold)

                            <div
                                class="grid grid-cols-[1fr_auto] items-center gap-6 border rounded-xl p-4 hover:bg-blue-100 w-full">

                                {{-- KIRI --}}
                                <label class="flex items-center gap-3 cursor-pointer">

                                    <input type="radio" name="hold_id" value="{{ $hold->id }}" required>

                                    <div>

                                        <h3 class="text-lg font-bold text-blue-700">
                                            {{ $hold->industry->nama_industri }}
                                        </h3>

                                        <p class="text-sm text-slate-500">
                                            Berakhir
                                            {{ $hold->hold_expired_at->format('d M Y H:i') }}
                                            WIB
                                        </p>

                                    </div>

                                </label>

                                {{-- KANAN --}}
                                <div id="countdown-{{ $hold->id }}"
                                    data-expired="{{ $hold->hold_expired_at->format('Y-m-d H:i:s') }}"
                                    class="flex gap-2 justify-end">
                                </div>

                            </div>

                            @endforeach

                        </div>



                    </div>



                </div>

            </div>

            <div>

                <label class="block mb-2 font-medium text-slate-700">

                    Upload Surat Penerimaan

                </label>

                <input type="file" name="file_bukti" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3" required>

            </div>

            <form action="{{ route('industry.upload-bukti') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5" onsubmit="localStorage.setItem('activeTab','upload')">

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition">

                    Simpan Bukti

                </button>

            </form>

            @else

            <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-5">

                <h3 class="font-semibold text-yellow-700">

                    Anda belum memiliki Hold Aktif.

                </h3>

                <p class="text-sm text-slate-600 mt-2">

                    Silakan kembali ke tab <b>Rekomendasi</b> lalu aktifkan Hold pada salah satu perusahaan terlebih
                    dahulu.

                </p>

            </div>

            @endif

        </form>
    </div>

    <!-- Riwayat -->
    <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <div class="flex justify-between items-center mb-4">

            <h2 class="text-xl font-bold text-slate-800">
                Riwayat Bukti Diterima
            </h2>

            <span class="bg-blue-100 text-blue-700
               px-3 py-1 rounded-full
               text-sm font-semibold">

                {{ $buktiPenerimaan->count() }} Perusahaan

            </span>

        </div>

        @forelse($buktiPenerimaan as $bukti)

        <div class="bg-white border border-slate-200
           rounded-2xl p-5 mb-4
           hover:shadow-md transition">

            <div class="flex justify-between items-start">

                <div>



                    <h3 class="text-lg font-bold text-slate-800">
                        {{ $bukti->industry->nama_industri }}
                    </h3>

                    <p class="text-sm text-slate-600 mt-2">
                        Mahasiswa:
                        <span class="font-semibold text-slate-800">
                            {{ $bukti->user->name }}
                        </span>
                    </p>

                    <p class="text-sm text-slate-500 mt-2">
                    <div class="flex items-center gap-2 text-slate-600 mt-2">

                        📄

                        <span>
                            Surat Penerimaan Magang
                        </span>

                    </div>
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Upload:
                        {{ $bukti->created_at->format('d M Y H:i') }}
                    </p>

                    <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4">

                        <p class="font-semibold text-green-700">

                            Mahasiswa telah diterima di perusahaan ini.

                        </p>

                        <p class="text-sm text-slate-600 mt-1">

                            Slot kuota perusahaan telah diperbarui secara otomatis.

                        </p>

                    </div>

                    @php

                    $terisi = $bukti->industry->kuota_terisi;

                    $kuota = $bukti->industry->kuota_magang;

                    $sisa = max(0, $kuota - $terisi);

                    @endphp

                    <div class="mt-5 border-t pt-4">

                        <p class="text-sm font-semibold text-slate-700 mb-2">

                            Status Kuota

                        </p>

                        <div class="flex items-center gap-2">

                            <span class="text-xl">👥</span>

                            <span class="font-bold text-slate-800">

                                {{ $terisi }} / {{ $kuota }}

                            </span>

                            <span class="text-slate-500">
                                Terisi
                            </span>

                        </div>

                        @if($sisa > 0)

                        <p class="text-xs text-green-600 mt-2">

                            Masih tersedia
                            <span class="font-bold">
                                {{ $sisa }} slot
                            </span>
                            magang

                        </p>

                        @else

                        <p class="text-xs text-red-600 mt-2">

                            Kuota perusahaan telah penuh

                        </p>

                        @endif

                    </div>

                </div>

                <a href="{{ asset('storage/'.$bukti->file_bukti) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700
                   text-white text-sm
                   px-4 py-2 rounded-xl">

                    Lihat Surat
                </a>

            </div>

        </div>

        @empty

        <div class="text-center py-10">

            <div class="text-5xl mb-3">
                📄
            </div>

            <h3 class="font-semibold text-slate-700">
                Belum Ada Bukti Diterima
            </h3>

            <p class="text-slate-500 mt-2">
                Upload surat penerimaan magang untuk
                memperbarui status perusahaan.
            </p>

        </div>

        @endforelse

    </div>

</div>
