<!-- TAB DAFTAR -->
<div id="content-daftar">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <!-- Total -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">

            <div class="text-sm text-slate-500">
                Total Perusahaan
            </div>

            <div class="mt-2 text-3xl font-bold text-slate-800">
                {{ $totalPerusahaan }}
            </div>

            <div class="mt-1 text-xs text-slate-400">
                Seluruh perusahaan yang tersedia
            </div>

        </div>

        <!-- Sudah Diterima -->
        <div class="bg-white rounded-2xl shadow-sm border border-green-200 p-5">

            <div class="text-sm text-green-600">
                Hold Aktif
            </div>

            <div class="mt-2 text-3xl font-bold text-green-700">
                {{ $totalHoldAktif }}
            </div>

            <div class="mt-1 text-xs text-green-500">
                Kuota perusahaan yang sedang digunakan
            </div>

        </div>

        <!-- Tersedia -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-5">

            <div class="text-sm text-blue-600">
                Kuota Tersedia
            </div>

            <div class="mt-2 text-3xl font-bold text-blue-700">
                {{ $totalTersedia }}
            </div>

            <div class="mt-1 text-xs text-blue-500">
                Perusahaan masih dapat direkomendasikan
            </div>

        </div>

    </div>

    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <div class="space-y-4 p-4">

            @forelse($industries as $i)

            <div class="company-card
            bg-white
            rounded-2xl
            shadow-md
            p-5
            border
            hover:shadow-lg
            transition">

                <div class="flex justify-between items-start">

                    <div class="flex-1">

                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $i->nama_industri }}
                        </h3>

                        <p class="text-gray-500 mt-2">
                            {{ $i->alamat_industri }}
                        </p>

                        <div class="mt-4">
                            <div class="grid grid-cols-3 gap-4 mt-5">

                                <div class="bg-blue-50 rounded-xl p-3 text-center">

                                    <p class="text-xs text-slate-500">
                                        Kuota
                                    </p>

                                    <p class="text-xl font-bold text-blue-700">
                                        {{ $i->kuota_magang }}
                                    </p>

                                </div>

                                <div class="bg-amber-50 rounded-xl p-3 text-center">

                                    <p class="text-xs text-slate-500">
                                        Terisi
                                    </p>

                                    <p class="text-xl font-bold text-amber-600">
                                        {{ $i->hold_aktif }}
                                    </p>

                                </div>

                                <div class="bg-green-50 rounded-xl p-3 text-center">

                                    <p class="text-xs text-slate-500">
                                        Sisa
                                    </p>

                                    <p class="text-xl font-bold text-green-600">
                                        {{ $i->sisa_kuota }}
                                    </p>

                                </div>

                            </div>

                            <div class="
    bg-slate-50
    border
    border-slate-200
    rounded-xl
    p-3 mt-4">

                                <p class="text-xs font-semibold text-slate-500 mb-1">
                                    Kualifikasi Skill
                                </p>


                                <div class="flex flex-wrap gap-2 mt-3">

                                    @foreach(explode(',', $i->kualifikasi_skill) as $skill)

                                    <span class="
    bg-blue-100
    text-blue-700
    px-3 py-1
    rounded-full
    text-xs">

                                        {{ trim($skill) }}

                                    </span>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="text-right">

                        @if($i->sisa_kuota > 0)

                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                            🟢 {{ $i->sisa_kuota }} Slot Tersisa
                        </span>

                        @else

                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                            🔴 Kuota Penuh
                        </span>

                        @endif

                    </div>
                </div>

            </div>

            @empty

            <div class="bg-yellow-50 p-5 rounded-xl">
                Belum ada perusahaan.
            </div>

            @endforelse

        </div>

        <div class="border-t border-gray-100 px-2">
            {{ $industries->links('pagination.custom') }}
        </div>
    </div>

</div>
