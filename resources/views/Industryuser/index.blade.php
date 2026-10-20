@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="bg-white rounded-2xl shadow-md p-5 mb-6">

        <div class="flex justify-between items-center">

            <div>
                <h2 class="text-xl font-bold">
                    Daftar Perusahaan Magang
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    {{ $industries->total() }} perusahaan tersedia
                </p>
            </div>

            <input type="text" id="searchCompany" placeholder="Cari perusahaan..."
                class="border rounded-xl px-4 py-2 w-72">

        </div>

    </div>



    <!-- Tabs -->
    <div class="flex justify-center mb-8">

        <div class="inline-flex bg-white p-1.5 rounded-2xl shadow-md border border-slate-200">

            <button id="tab-daftar" onclick="showTab('daftar')"
                class="tab-btn active-tab px-8 py-3 rounded-xl font-semibold">
                Daftar Perusahaan
            </button>

            <button id="tab-konfirmasi" onclick="showTab('konfirmasi')"
                class="tab-btn px-8 py-3 rounded-xl font-semibold">
                Rekomendasi
            </button>

            <button id="tab-upload" onclick="showTab('upload')" class="tab-btn px-8 py-3 rounded-xl font-semibold">
                Upload Bukti Diterima
            </button>


        </div>

    </div>

    <!-- TAB DAFTAR -->
    @include('industryuser.partials.daftar-perusahaan')

    <!-- TAB UPLOAD -->
    @include('industryuser.partials.upload-bukti')

    <!-- TAB konfirmasi -->
    @include('industryuser.partials.konfirmasi')

</div>
<style>
.tab-btn {
    color: #64748B;
    transition: all .25s ease;
}

.tab-btn:hover {
    color: #2563EB;
}

.active-tab {
    background: #2563EB;
    color: white !important;
    box-shadow:
        0 4px 12px rgba(37, 99, 235, .25);
}
</style>



<script>
function showTab(tab) {
    localStorage.setItem('activeTab', tab);

    const daftar = document.getElementById('content-daftar');
    const upload = document.getElementById('content-upload');
    const konfirmasi = document.getElementById('content-konfirmasi');

    const btnDaftar = document.getElementById('tab-daftar');
    const btnUpload = document.getElementById('tab-upload');
    const btnKonfirmasi = document.getElementById('tab-konfirmasi');

    // Sembunyikan semua content
    daftar.classList.add('hidden');
    upload.classList.add('hidden');
    konfirmasi.classList.add('hidden');

    // Reset semua tombol
    btnDaftar.classList.remove('active-tab');
    btnUpload.classList.remove('active-tab');
    btnKonfirmasi.classList.remove('active-tab');

    // Tampilkan tab yang dipilih
    if (tab === 'daftar') {

        daftar.classList.remove('hidden');
        btnDaftar.classList.add('active-tab');

    } else if (tab === 'upload') {

        upload.classList.remove('hidden');
        btnUpload.classList.add('active-tab');

    } else if (tab === 'konfirmasi') {

        konfirmasi.classList.remove('hidden');
        btnKonfirmasi.classList.add('active-tab');

    }
}

function initTabs() {

    const activeTab =
        localStorage.getItem(
            'activeTab'
        );

    showTab(
        activeTab ??
        'daftar'
    );

}

function initSearch() {

    const search =
        document.getElementById(
            'searchCompany'
        );

    if (!search) return;

    search.addEventListener(
        'keyup',
        function() {

            const value =
                this.value.toLowerCase();

            document
                .querySelectorAll('.company-card')
                .forEach(card => {

                    card.style.display =
                        card.innerText
                        .toLowerCase()
                        .includes(value) ?
                        '' :
                        'none';

                });

        }
    );

}

document.addEventListener(
    'DOMContentLoaded',
    function() {

        initTabs();

        initSearch();

    }
);
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll("[data-expired]").forEach(function(card) {

        const expiredAt = new Date(card.dataset.expired).getTime();

        function updateCountdown() {

            const now = new Date().getTime();

            const distance = expiredAt - now;

            if (distance <= 0) {

                card.innerHTML =
                    `<span class="text-red-600 font-semibold">
                    Hold Berakhir
                </span>`;

                return;
            }

            const hari = Math.floor(distance / (1000 * 60 * 60 * 24));

            const jam = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            const menit = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

            const detik = Math.floor((distance % (1000 * 60)) / 1000);

            card.innerHTML = `

                <div class="bg-blue-600 text-white rounded-xl w-16 py-2 text-center shadow">

                    <div class="text-xl font-bold">${hari}</div>

                    <div class="text-xs">Hari</div>

                </div>

                <div class="bg-blue-600 text-white rounded-xl w-16 py-2 text-center shadow">

                    <div class="text-xl font-bold">${jam}</div>

                    <div class="text-xs">Jam</div>

                </div>

                <div class="bg-blue-600 text-white rounded-xl w-16 py-2 text-center shadow">

                    <div class="text-xl font-bold">${menit}</div>

                    <div class="text-xs">Menit</div>

                </div>

                <div class="bg-blue-600 text-white rounded-xl w-16 py-2 text-center shadow">

                    <div class="text-xl font-bold">${detik}</div>

                    <div class="text-xs">Detik</div>

                </div>

            `;

        }

        updateCountdown();

        setInterval(updateCountdown, 1000);

    });

});
</script>

@endsection
