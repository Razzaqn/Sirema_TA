@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-6 items-start min-h-screen">

    <!-- FORM -->
    <div class="col-span-8">
        <div class="bg-white p-6 rounded-2xl shadow-md w-full h-fit">

            <h2 class="text-xl font-semibold mb-4">Input Nilai (KHS)</h2>

            <!-- FORM FILTER SEMESTER (GET) -->
            <form method="GET" action="{{ route('profil.index') }}" class="mb-4">
                <label class="block mb-1 font-medium">Semester</label>
                <select name="semester" onchange="this.form.submit()"
                    class="form-select w-full border rounded px-3 py-2">
                    <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester 2</option>
                    <option value="3" {{ $semester == 3 ? 'selected' : '' }}>Semester 3</option>
                </select>
            </form>

            <!-- FORM INPUT NILAI (POST) -->
            <form id="form-khs">
                @csrf
                <input type="hidden" name="c1" id="input-c1">
                <input type="hidden" name="bidang_dominan" id="input-bidang">

                <!-- 🔥 kirim semester ke backend -->
                <input type="hidden" name="semester" value="{{ $semester }}">
                @php
                $nilaiMap = [];
                foreach ($nilai as $n) {
                $nilaiMap[$n->mata_kuliah_id] = $n->nilai_mutu;
                }
                @endphp

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 text-left">Mata Kuliah</th>
                                <th class="p-2 text-left">Nilai</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $nilaiMap = [];
                            foreach ($nilai as $n) {
                            $nilaiMap[$n->mata_kuliah_id] = $n->nilai_mutu;
                            }
                            @endphp
                            @forelse($mataKuliah as $mk)
                            <tr class="border-t">
                                <td class="p-2">
                                    {{ $mk->nama }} (S{{ $mk->semester }})
                                </td>
                                <td class="p-3">
                                    <select name="nilai[{{ $mk->id }}]" class="nilai-select"
                                        data-mata-kuliah="{{ $mk->id }}"
                                        data-bidang='@json($mk->bidangKompetensi->pluck("bidang"))'>

                                        <option value="">-</option>
                                        <option value="4" {{ ($nilaiMap[$mk->id] ?? '') == 4 ? 'selected' : '' }}>4
                                        </option>
                                        <option value="3.5" {{ ($nilaiMap[$mk->id] ?? '') == 3.5 ? 'selected' : '' }}>
                                            3.5
                                        </option>
                                        <option value="3" {{ ($nilaiMap[$mk->id] ?? '') == 3 ? 'selected' : '' }}>3
                                        </option>
                                        <option value="2.5" {{ ($nilaiMap[$mk->id] ?? '') == 2.5 ? 'selected' : '' }}>
                                            2.5
                                        </option>
                                        <option value="2" {{ ($nilaiMap[$mk->id] ?? '') == 2 ? 'selected' : '' }}>2
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                @forelse($mataKuliah as $mk)
                            <tr>
                                <td>{{ $mk->nama }}</td>
                                <td>
                                    <input type="number" name="nilai[{{ $mk->id }}]" class="border p-1 rounded w-24">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-gray-500">
                                    Tidak ada mata kuliah di semester ini
                                </td>
                            </tr>
                            @endforelse
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- BUTTON -->
                <div class="mt-4">
                    <button type="submit" id="btn-simpan"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Simpan & Hitung
                    </button>
                </div>

            </form>


        </div>
        <div class="bg-white shadow rounded-xl p-6 mt-6">

            <h2 class="text-xl font-semibold mb-4">
                Minat Magang Mahasiswa
            </h2>

            <p class="text-gray-500 text-sm mb-4">
                Pilih bidang minat magang yang sesuai
                dengan ketertarikan Anda.
            </p>

            <form id="form-minat">

                @csrf

                <div class="grid grid-cols-2 gap-4">

                    @php
                    $opsiMinat = [
                    'Web Developer',
                    'Mobile Developer',
                    'Administrator Sistem & Jaringan',
                    'Administrator Basis Data'
                    ];
                    @endphp

                    @foreach($opsiMinat as $minat)
                    <label class="flex items-center gap-2
                border rounded-lg p-3 hover:bg-blue-50 cursor-pointer">

                        <input class="minat-checkbox" type="checkbox" name="minat[]" value="{{ $minat }}" {{ in_array($minat, $minatTerpilih ?? [])
                    ? 'checked' : '' }} class="rounded text-blue-600">

                        <span>{{ $minat }}</span>
                    </label>
                    @endforeach

                </div>

                <button type="submit" class="mt-5 bg-blue-600 text-white
            px-4 py-2 rounded-lg hover:bg-blue-700">

                    Simpan Minat
                </button>

            </form>
        </div>

    </div>
    <div class="col-span-4 h-full">
        <div class="sticky top-6 h-[calc(100vh-100px)] overflow-y-auto pr-2 pb-24 space-y-4">
            <div
                class="bg-white rounded-2xl shadow-md border border-gray-100 p-5 hover:shadow-lg transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800">
                        Semester 1
                    </h3>

                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        Rekap Kompetensi
                    </span>
                </div>

                <div id="rekap-smt-1" class="space-y-1 text-sm"></div>

                <div class="mt-3 pt-2 border-t text-sm">
                    <span class="text-gray-600">Bidang Dominan:</span>
                    <span id="dominan-smt-1" class="font-semibold text-blue-600">-</span>
                </div>
            </div>
            <div
                class="bg-white rounded-2xl shadow-md border border-gray-100 p-5 hover:shadow-lg transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800">
                        Semester 2
                    </h3>

                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        Rekap Kompetensi
                    </span>
                </div>

                <div id="rekap-smt-2" class="space-y-1 text-sm"></div>

                <div class="mt-3 pt-2 border-t text-sm">
                    <span class="text-gray-600">Bidang Dominan:</span>
                    <span id="dominan-smt-2" class="font-semibold text-blue-600">-</span>
                </div>
            </div>
            <div
                class="bg-white rounded-2xl shadow-md border border-gray-100 p-5 hover:shadow-lg transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800">
                        Semester 3
                    </h3>

                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        Rekap Kompetensi
                    </span>
                </div>

                <div id="rekap-smt-3" class="space-y-1 text-sm"></div>

                <div class="mt-3 pt-2 border-t text-sm">
                    <span class="text-gray-600">Bidang Dominan:</span>
                    <span id="dominan-smt-3" class="font-semibold text-blue-600">-</span>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700
text-white rounded-2xl shadow-xl p-5">

                <h3 class="font-bold text-lg mb-4">
                    📊 Total Kompetensi
                </h3>

                <p class="text-blue-100 text-sm mb-4">
                    Rata-rata Semester 1–3
                </p>

                <div id="rekap-total" class="space-y-2 text-sm"></div>

                <div class="mt-4 pt-4 border-t border-white/20">
                    <p class="text-sm text-blue-100">
                        Bidang Dominan
                    </p>

                    <h4 id="dominan-total" class="font-bold text-lg">
                        -
                    </h4>

                    <div class="mt-3">
                        <span class="text-sm text-blue-100">
                            Nilai C1
                        </span>

                        <div class="text-2xl font-bold" id="nilai-c1">
                            0.00
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <script>
    document.addEventListener("DOMContentLoaded", function() {

        let urlParams = new URLSearchParams(window.location.search);
        let semesterAktif = parseInt(urlParams.get('semester')) || 1;

        const profilData = document.getElementById('profil-data');

        const dataKHS = @json($nilai);

        const bidangList = [
            "Web Developer",
            "Mobile App Developer",
            "Administrator Basis Data",
            "Administrator Sistem & Jaringan Komputer"
        ];

        document.querySelectorAll('.nilai-select').forEach(select => {
            select.addEventListener('change', hitungSemua);
        });

        function hitungSemua() {

            const semesterAktif =
                parseInt(document.querySelector('[name="semester"]').value) || 1;

            const bidangList = [
                "Web Developer",
                "Mobile App Developer",
                "Administrator Basis Data",
                "Administrator Sistem & Jaringan Komputer"
            ];

            /*
            |--------------------------------------------------------------------------
            | Struktur data
            |--------------------------------------------------------------------------
            */

            const data = {};

            bidangList.forEach(bidang => {
                data[bidang] = {};
            });


            /*
            |--------------------------------------------------------------------------
            | 1. Ambil semua nilai yang sudah tersimpan
            |--------------------------------------------------------------------------
            */

            dataKHS.forEach(item => {

                const semester = parseInt(item.semester);
                const nilai = parseFloat(item.nilai_mutu || 0);

                if (!semester || !nilai) {
                    return;
                }

                const mk = item.mata_kuliah;

                if (!mk) {
                    return;
                }

                const mappings = mk.bidang_kompetensi || [];

                mappings.forEach(mapping => {

                    const bidang = mapping.bidang;

                    if (!bidangList.includes(bidang)) {
                        return;
                    }

                    /*
                    | Semester aktif nanti dihitung dari dropdown
                    */

                    if (semester === semesterAktif) {
                        return;
                    }

                    if (!data[bidang][semester]) {
                        data[bidang][semester] = [];
                    }

                    data[bidang][semester].push(nilai);

                });

            });


            /*
            |--------------------------------------------------------------------------
            | 2. Ambil nilai dari dropdown semester aktif
            |--------------------------------------------------------------------------
            */

            document.querySelectorAll('.nilai-select').forEach(select => {

                const nilai = parseFloat(select.value || 0);

                if (!nilai) {
                    return;
                }

                const bidangData =
                    select.dataset.bidang;

                if (!bidangData) {
                    return;
                }

                let mappings;

                try {

                    mappings = JSON.parse(bidangData);

                } catch (error) {

                    console.error(
                        'Gagal membaca mapping bidang:',
                        error
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Masukkan nilai ke semua bidang yang dimiliki mata kuliah
                |--------------------------------------------------------------------------
                */

                mappings.forEach(bidang => {

                    if (!bidangList.includes(bidang)) {
                        return;
                    }

                    if (!data[bidang][semesterAktif]) {
                        data[bidang][semesterAktif] = [];
                    }

                    data[bidang][semesterAktif].push(nilai);

                });

            });


            /*
            |--------------------------------------------------------------------------
            | 3. Hitung rata-rata per semester
            |--------------------------------------------------------------------------
            */

            const hasilSemester = {};

            bidangList.forEach(bidang => {

                hasilSemester[bidang] = {};

                Object.keys(data[bidang]).forEach(semester => {

                    const list =
                        data[bidang][semester];

                    if (!list || list.length === 0) {

                        hasilSemester[bidang][semester] = 0;

                        return;
                    }

                    const total =
                        list.reduce(
                            (sum, nilai) => sum + nilai,
                            0
                        );

                    hasilSemester[bidang][semester] =
                        total / list.length;

                });

            });


            /*
            |--------------------------------------------------------------------------
            | 4. Hitung rata-rata total Semester 1-3
            |--------------------------------------------------------------------------
            */

            const hasilFinal = {};

            bidangList.forEach(bidang => {

                let total = 0;
                let jumlahSemester = 0;

                Object.keys(
                    hasilSemester[bidang]
                ).forEach(semester => {

                    const nilai =
                        hasilSemester[bidang][semester];

                    if (nilai > 0) {

                        total += nilai;
                        jumlahSemester++;

                    }

                });

                hasilFinal[bidang] =
                    jumlahSemester > 0 ?
                    total / jumlahSemester :
                    0;

            });


            /*
            |--------------------------------------------------------------------------
            | 5. Tampilkan
            |--------------------------------------------------------------------------
            */

            tampilkanSemester(
                1,
                hasilSemester
            );

            tampilkanSemester(
                2,
                hasilSemester
            );

            tampilkanSemester(
                3,
                hasilSemester
            );

            tampilkanTotal(
                hasilFinal
            );

        }

        function tampilkanSemester(semester, data) {

            const kategoriList = [
                "Web Developer",
                "Mobile App Developer",
                "Administrator Basis Data",
                "Administrator Sistem & Jaringan Komputer"
            ];

            let html = '';

            let maxVal = 0;
            let maxBidang = '';

            kategoriList.forEach(bidang => {

                const nilai =
                    data[bidang]?. [semester] || 0;


                /*
                |--------------------------------------------------------------------------
                | Cari bidang dengan nilai tertinggi
                |--------------------------------------------------------------------------
                */

                if (nilai > maxVal) {
                    maxVal = nilai;
                    maxBidang = bidang;
                }


                /*
                |--------------------------------------------------------------------------
                | Warna nilai
                |--------------------------------------------------------------------------
                */

                let warna;

                if (nilai >= 3.5) {

                    warna =
                        'bg-green-100 text-green-700';

                } else if (nilai >= 3) {

                    warna =
                        'bg-blue-100 text-blue-700';

                } else {

                    warna =
                        'bg-gray-200 text-gray-700';

                }


                html += `
            <div class="flex items-center justify-between
                bg-slate-50 hover:bg-slate-100
                rounded-xl px-4 py-2 transition
                min-h-[56px]">

                <div class="flex-1 pr-2">

                    <p class="text-sm text-gray-700 leading-5">
                        ${bidang}
                    </p>

                </div>

                <span class="
                    shrink-0 min-w-[68px]
                    text-center
                    px-3 py-1
                    rounded-full
                    text-sm
                    font-bold
                    ${warna}
                ">
                    ${nilai.toFixed(2)}
                </span>

            </div>
        `;

            });


            document.getElementById(
                'rekap-smt-' + semester
            ).innerHTML = html;


            document.getElementById(
                    'dominan-smt-' + semester
                ).innerText =
                maxBidang || '-';

        }

        function tampilkanTotal(data) {

            if (!data) return;


            const kategoriList = [
                "Web Developer",
                "Mobile App Developer",
                "Administrator Basis Data",
                "Administrator Sistem & Jaringan Komputer"
            ];


            let html = '';

            let maxVal = 0;
            let maxBidang = '';


            kategoriList.forEach(bidang => {

                const nilai =
                    data[bidang] || 0;


                html += `
            <div class="flex justify-between border-b py-1">

                <span>
                    ${bidang}
                </span>

                <span>
                    ${nilai.toFixed(2)}
                </span>

            </div>
        `;


                if (nilai > maxVal) {

                    maxVal = nilai;
                    maxBidang = bidang;

                }

            });


            document.getElementById(
                'rekap-total'
            ).innerHTML = html;


            document.getElementById(
                    'dominan-total'
                ).innerText =
                maxBidang || '-';


            document.getElementById(
                    'nilai-c1'
                ).innerText =
                maxVal.toFixed(2);

        }
        hitungSemua(); // 🔥 auto jalan saat load
    });

    //SweetAlert popup simpan & hitung
    document.getElementById('form-khs')
        .addEventListener('submit', function(e) {

            e.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('profil.simpan') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                })
                .then(async response => {

                    let text = await response.text();

                    console.log("STATUS:", response.status);
                    console.log("RESPONSE:", text);

                    try {
                        return JSON.parse(text);
                    } catch {
                        throw new Error(text);
                    }
                })
                .then(data => {

                    console.log(data);

                    if (data.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Nilai berhasil disimpan',
                            confirmButtonText: 'Oke',
                            timer: 1800,
                            timerProgressBar: true
                        }).then(() => {
                            location.reload();
                        });
                    }

                })
                .catch(error => {

                    console.error(error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal menyimpan nilai',
                        confirmButtonText: 'Coba Lagi'
                    });
                });

        });

    //SweetAlert popup minat
    document.getElementById('form-minat')
        .addEventListener('submit', function(e) {

            e.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('profil.minat.simpan') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .content,
                        "Accept": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {

                    if (data.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Minat magang berhasil disimpan',
                            confirmButtonText: 'Oke',
                            timer: 1800,
                            timerProgressBar: true
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal menyimpan minat'
                        });

                    }
                })
                .catch(error => {

                    console.error(error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan sistem'
                    });

                });
        });

    const checkboxes = document.querySelectorAll('.minat-checkbox');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {

            const checked = document.querySelectorAll('.minat-checkbox:checked');


            if (checked.length > 2) {

                this.checked = false;

                Swal.fire({
                    icon: 'warning',
                    title: 'Batas Minat Tercapai',
                    text: 'Anda hanya dapat memilih maksimal 2 bidang minat.',
                    confirmButtonColor: '#2563eb'
                });

            }

        });
    });
    </script>

    @endsection