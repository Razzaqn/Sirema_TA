<!-- TAB konfirmasi -->
<div id="content-konfirmasi" class="hidden">

    <div class="bg-white rounded-3xl shadow-md p-8">

        <div class="flex justify-between items-center mb-6">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Konfirmasi Rekomendasi
                </h2>

                <p class="text-slate-500">
                    Kelola perusahaan hasil rekomendasi Anda.
                </p>

            </div>

            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">

                Top {{ $konfirmasi->count() }} Rekomendasi

            </span>

        </div>

        @forelse($konfirmasi as $item)

        {{-- Card di bawah --}}
        <div class="border rounded-2xl p-6 mb-5 hover:shadow-lg transition">

            <div class="flex justify-between">

                <div>

                    <div class="flex items-center gap-3">

                        <h3 class="text-xl font-bold">

                            {{ $item->industry->nama_industri }}

                        </h3>

                        @if($item->status=='direkomendasikan')

                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">

                            Direkomendasikan

                        </span>

                        @elseif($item->status=='hold_aktif')

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">

                            Hold Aktif

                        </span>

                        @endif

                    </div>

                    <div class="mt-3 text-gray-500">

                        Ranking {{ $item->ranking }}

                    </div>

                    <div class="mt-2">

                        <p class="mt-1 text-lg font-semibold">
                            {{ $item->jumlah_hold }} / {{ $item->industry->kuota_magang }} Terisi
                        </p>

                        <p class="text-sm text-slate-500">
                            Masih tersedia {{ $item->sisa_kuota }} slot
                        </p>

                        <div class="w-full bg-slate-200 rounded-full h-2 mt-3">

                            <div class="bg-blue-600 h-2 rounded-full" @style([ 'width: ' .$item->
                                persentase_hold.'%;'
                                ])>
                            </div>

                        </div>

                    </div>

                    <div class="mt-5">

                        <h4 class="text-sm font-semibold text-slate-700 mb-3">
                            Mahasiswa Hold Aktif
                        </h4>

                        @foreach($item->holdAktif as $hold)

                        <div class="flex items-center gap-2 mb-2">

                            <div
                                class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold">

                                {{ strtoupper(substr($hold->user->name,0,1)) }}

                            </div>

                            <span class="text-sm">

                                {{ $hold->user->name }}

                            </span>

                        </div>

                        @endforeach

                        @for($i = $item->holdAktif->count(); $i < $item->industry->kuota_magang; $i++)

                            <div class="flex items-center gap-2 mb-2 opacity-60">

                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">

                                    +

                                </div>

                                <span class="text-sm text-gray-400">

                                    Slot Kosong

                                </span>

                            </div>

                            @endfor

                    </div>

                </div>

                <div class="text-right">

                    @if($item->status=='direkomendasikan')

                    <form action="{{ route('konfirmasi.hold',$item->id) }}" method="POST"
                        onsubmit="localStorage.setItem('activeTab','konfirmasi')">

                        @csrf

                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl">

                            Aktifkan Hold

                        </button>

                    </form>

                    @elseif($item->status=='hold_aktif')

                    <div class="text-right space-y-3">

                        <div class="bg-green-50 border border-green-200 rounded-xl p-3">

                            <p class="text-xs text-slate-500">
                                Hold Berakhir
                            </p>

                            <p class="font-bold text-green-700">

                                {{ $item->hold_expired_at->format('d M Y') }}

                            </p>

                            <p class="text-xs text-slate-500">

                                {{ $item->hold_expired_at->format('H:i') }} WIB

                            </p>

                        </div>

                        <form action="{{ route('konfirmasi.cancel',$item->id) }}" method="POST"
                            onsubmit="localStorage.setItem('activeTab','konfirmasi')">

                            @csrf

                            <button class="w-full bg-red-600 hover:bg-red-700
                   text-white py-2 rounded-xl">

                                Batalkan Hold

                            </button>

                        </form>

                    </div>

                    @endif

                </div>

            </div>

        </div>

        @empty

        <div class="text-center py-10 text-slate-500">

            Belum ada hasil rekomendasi.

        </div>

        @endforelse

    </div>

</div>
