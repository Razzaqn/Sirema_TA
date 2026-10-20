<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;
use App\Models\MinatMahasiswa;

class ProfilKompetensiController extends Controller
{
    public function index(Request $request)
    {
        $semester = $request->semester ?? 1;

        $mataKuliah = MataKuliah::with('bidangKompetensi')
            ->where('semester', $semester)
            ->get();

        $nilai = Nilai::with([
            'mataKuliah.bidangKompetensi'
        ])
            ->where('user_id', Auth::id())
            ->orderBy('semester')
            ->get();

        $minatTerpilih = MinatMahasiswa::where(
            'user_id',
            Auth::id()
        )->pluck('bidang')->toArray();


        return view('profil.index', compact('mataKuliah', 'semester', 'nilai', 'minatTerpilih'));
    }

    // 🔥 INI YANG MENYIMPAN NILAI DARI FORM
    public function hitung()
    {
        return $this->prosesHitung();
    }

    // 🔥 INI YANG MENGHITUNG PROFIL KOMPETENSI
    private function prosesHitung()
{
    $data = Nilai::with([
        'mataKuliah.bidangKompetensi'
    ])
    ->where('user_id', Auth::id())
    ->get();

    /*
    |--------------------------------------------------------------------------
    | Daftar 4 bidang kompetensi SIREMA
    |--------------------------------------------------------------------------
    */

    $bidangList = [
        'Web Developer',
        'Mobile App Developer',
        'Administrator Basis Data',
        'Administrator Sistem & Jaringan Komputer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Inisialisasi hasil
    |--------------------------------------------------------------------------
    */

    $result = [];

    foreach ($bidangList as $bidang) {
        $result[$bidang] = [];
    }

    /*
    |--------------------------------------------------------------------------
    | Kelompokkan nilai berdasarkan bidang dan semester
    |--------------------------------------------------------------------------
    */

    foreach ($data as $d) {

        // Pastikan mata kuliah tersedia
        if (!$d->mataKuliah) {
            continue;
        }

        // Ambil semua bidang dari relasi
        $bidangKompetensi = $d->mataKuliah->bidangKompetensi;

        // Mata kuliah umum yang tidak memiliki bidang
        if ($bidangKompetensi->isEmpty()) {
            continue;
        }

        $semester = $d->semester;
        $nilai = $d->nilai_mutu;

        /*
        |--------------------------------------------------------------------------
        | Satu mata kuliah dapat masuk ke lebih dari satu bidang
        |--------------------------------------------------------------------------
        */

        foreach ($bidangKompetensi as $mapping) {

            $bidang = $mapping->bidang;

            $result[$bidang][$semester][] = $nilai;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Hitung rata-rata setiap bidang
    |--------------------------------------------------------------------------
    */

    $nilaiBidang = [];

    foreach ($bidangList as $bidang) {

        $semesters = $result[$bidang];

        /*
        | Jika bidang belum memiliki nilai
        */

        if (empty($semesters)) {
            $nilaiBidang[$bidang] = 0;
            continue;
        }

        $totalSemester = 0;
        $sumSemester = 0;

        /*
        |--------------------------------------------------------------------------
        | Rata-rata nilai dalam setiap semester
        |--------------------------------------------------------------------------
        */

        foreach ($semesters as $semester => $nilaiList) {

            if (count($nilaiList) === 0) {
                continue;
            }

            $avgSemester = array_sum($nilaiList) / count($nilaiList);

            $sumSemester += $avgSemester;
            $totalSemester++;
        }

        /*
        |--------------------------------------------------------------------------
        | Rata-rata antar semester
        |--------------------------------------------------------------------------
        */

        if ($totalSemester > 0) {

            $nilaiBidang[$bidang] =
                $sumSemester / $totalSemester;

        } else {

            $nilaiBidang[$bidang] = 0;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Tentukan bidang dominan
    |--------------------------------------------------------------------------
    */

    $dominan = collect($nilaiBidang)
        ->sortDesc()
        ->keys()
        ->first();

    return view(
        'profil.hasil',
        compact(
            'nilaiBidang',
            'dominan'
        )
    );
}

    public function simpan(Request $request)
{
    if (!$request->has('nilai')) {
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada nilai dikirim'
        ], 400);
    }

    $konversi = [
        '4' => 4,
        '3.5' => 3.5,
        '3' => 3,
        '2.5' => 2.5,
        '2' => 2
    ];

    foreach ($request->nilai as $mk_id => $nilaiHuruf) {

        if (!$nilaiHuruf) continue;

        Nilai::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'mata_kuliah_id' => $mk_id,
                'semester' => $request->semester
            ],
            [
                'nilai_huruf' => $nilaiHuruf,
                'nilai_mutu' => $konversi[$nilaiHuruf] ?? 0,
            ]
        );
    }

    return response()->json([
        'success' => true
    ]);
}
public function simpanMinat(Request $request)
{
    $request->validate([
    'minat' => 'required|array|max:2',
    'minat.*' => 'string'
]);

    MinatMahasiswa::where(
        'user_id',
        Auth::id()
    )->delete();

    if ($request->has('minat')) {

        foreach ($request->minat as $bidang) {

            MinatMahasiswa::create([
                'user_id' => Auth::id(),
                'bidang' => $bidang
            ]);
        }
    }

    return response()->json([
    'success' => true
]);
}
}
