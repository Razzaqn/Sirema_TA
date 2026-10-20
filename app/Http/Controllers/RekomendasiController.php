<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Industry;
use App\Models\RekomendasiSession;
use App\Models\HasilRekomendasi;
use App\Models\Nilai;
use App\Models\MinatMahasiswa;
use App\Models\BuktiPenerimaan;
use App\Models\KonfirmasiRekomendasi;

class RekomendasiController extends Controller
{
    // ==========================
// KEYWORD MATCHING
// ==========================

private const WEB_KEYWORDS = [
    'web developer',
'web development',
'full stack',
'fullstack',
'fullstack engineer',
'frontend',
'backend',
'frontend developer',
'frontend development',
'backend developer',
'backend development',
'frontend engineer',
'backend engineer',
'web programmer',
'php',
'laravel',
'codeigniter',
'symfony',
'javascript',
'typescript',
'html',
'css',
'bootstrap',
'tailwind',
'react',
'nextjs',
'next.js',
'vue',
'nuxt',
'angular',
'node',
'nodejs',
'express',
'rest api',
'graphql',
'web application',
'website',
'web app',
'full-stack',
'frontend web',
'backend web',
'ajax',
'jquery',
'npm',
'vite',
'webpack',
'json',
'api',
];

private const MOBILE_KEYWORDS = [
    'mobile developer',
'mobile programmer',
'android',
'android developer',
'ios',
'ios developer',
'flutter',
'dart',
'kotlin',
'java',
'swift',
'react native',
    'android & ios app development',
    'mobile app',
'app developer',
'application developer',
'mobile application',
'android studio',
'jetpack compose',
'xml',
];

private const DATABASE_KEYWORDS = [
'database',
'database administrator',
'dba',
'data engineer',
'data analyst',
'data science',
'big data',
'mysql',
'postgresql',
'postgres',
'oracle',
'mongodb',
'mariadb',
'sql server',
'sql',
'erd',
'query',
'stored procedure',
'database design',
'data warehouse',
'firebase',
'supabase',
];

private const NETWORK_KEYWORDS = [
    'network',
'network engineer',
'network administrator',
'system administrator',
'system admin',
'it support',
'administrator Jaringan',
'infrastructure',
'linux',
'windows server',
'active directory',
'mikrotik',
'cisco',
'ccna',
'vmware',
'virtualization',
'server',
'system engineer',
'devops',
'docker',
'nginx',
'apache',
'cloud',
'aws',
'azure',
'gcp',
];


    public function simpanNilai(Request $request)
    {


        $request->validate([
            'nilai' => 'required|array',
            'nilai.*.C2' => 'required|numeric|min:0',
    'nilai.*.C3' => 'required',
    'nilai.*.C4' => 'required',
        ]);

        // simpan semua nilai
        session([
            'nilai_alternatif' => $request->nilai
        ]);

        return redirect()->route('rekomendasi.waspas');
    }


    public function stepNilai()
    {
        $perusahaan = session('perusahaan') ?? [];

        // contoh ambil dari profil kompetensi
        $c1 = [];
        foreach ($perusahaan as $p) {
            $c1Session = session('c1');

            $c1[$p->id] = $c1Session[$p->id] ?? 0;
        }

        return view('rekomendasi.step3', compact('perusahaan', 'c1'));
    }

        // ======================================================
    // INPUT DATA
    // ======================================================
        public function input()
    {
        return view('rekomendasi.input');
    }


        // =========================
        // AHP
        // =========================
        public function hitungAHP(Request $request)
        {

            $kriteria = ['C1', 'C2', 'C3', 'C4'];
            $n = count($kriteria);

            // ambil input dari form
            $input = [];
            foreach ($request->nilai as $k1 => $row) {
                foreach ($row as $k2 => $value) {
                    $input[] = [$k1, $k2, $value];
                }
            }

            // =========================
            // MATRRIKS
            // =========================
            $matriks = [];

            foreach ($kriteria as $i) {
                foreach ($kriteria as $j) {
                    $matriks[$i][$j] = ($i == $j) ? 1 : 0;
                }
            }

            foreach ($input as $row) {
                [$k1, $k2, $nilai] = $row;
                $matriks[$k1][$k2] = $nilai;
                $matriks[$k2][$k1] = 1 / $nilai;
            }


            // =========================
            // NORMALISASI
            // =========================
            $jumlahKolom = [];

            foreach ($kriteria as $j) {
                $jumlahKolom[$j] = array_sum(array_column($matriks, $j));
            }

            $normalisasi = [];


            foreach ($kriteria as $i) {
                foreach ($kriteria as $j) {
                    $normalisasi[$i][$j] = $matriks[$i][$j] / $jumlahKolom[$j];
                }
            }



            // =========================
            // BOBOT
            // =========================
            $bobot = [];

            foreach ($kriteria as $i) {
                $bobot[$i] = array_sum($normalisasi[$i]) / $n;
            }

            // =========================
            // DETAIL PERHITUNGAN (BARU 🔥)
            // =========================
            $detailPerhitungan = [];

            foreach ($kriteria as $i) {
                $total = 0;
                $rumus = [];

                foreach ($kriteria as $j) {
                    $value = $matriks[$i][$j];
                    $hasil = $value * $bobot[$j];

                    $total += $hasil;
                    $rumus[] = "(" . rtrim(rtrim(number_format($value, 3), '0'), '.') . " × " . number_format($bobot[$j], 4) .")";
                }

                $detailPerhitungan[$i] = [
                    'rumus' => implode(' + ', $rumus),
                    'hasil' => $total,
                    'lambda' => $total / $bobot[$i]
                ];
            }

            // =========================
            // CR
            // =========================
            $detailLambda = [];
            $totalLambda = 0;

            foreach ($kriteria as $i) {

        $nilaiLambda = $detailPerhitungan[$i]['lambda'];

        $detailLambda[$i] = $nilaiLambda;

        $totalLambda += $nilaiLambda;
    }

            // Hitung λmax
            $lambdaMax = $totalLambda / $n;

            // Hitung Consistency Index (CI)
            $CI = max(0, ($lambdaMax - $n) / ($n - 1));

            $riTable = [
                1 => 0,
                2 => 0,
                3 => 0.58,
                4 => 0.90,
                5 => 1.12,
            ];

            $RI = $riTable[$n] ?? 1.12;

            // Hitung Consistency Ratio (CR)
            $CR = ($RI == 0) ? 0 : $CI / $RI;

            session([
                'matriks' => $matriks,
                'jumlahKolom' => $jumlahKolom,
                'normalisasi' => $normalisasi,
                'bobot' => $bobot,
                'bobot_ahp' => $bobot,
                'cr' => $CR,
                'CI' => $CI,
                'lambdaMax' => $lambdaMax,
                'detailPerhitungan' => $detailPerhitungan,
                'detailLambda' => $detailLambda,
                'totalLambda' => $totalLambda,
            ]);
            return redirect()->route('rekomendasi.bobot');
        }


    public function bobot()
    {

        return view('rekomendasi.bobot', [
            'matriks' => session('matriks'),
            'jumlahKolom' => session('jumlahKolom'),
            'normalisasi' => session('normalisasi'),

            'bobot' => session('bobot'),
            'CR' => session('cr'),
            'CI' => session('CI'),
            'lambdaMax' => session('lambdaMax'),
            'detailPerhitungan' => session('detailPerhitungan'),
            'detailLambda' => session('detailLambda'),
            'totalLambda' => session('totalLambda'),

        ]);
    }

    // =========================
    // WASPAS
    // =========================
    public function waspas()
{
$bobot = session('bobot') ?? [];

$rekomendasi = RekomendasiSession::create([

    'user_id' => Auth::id(),

    'bobot_ahp' => json_encode(
        session('bobot_ahp')
    ),

    'cr' => session('cr')

]);

$data = $this->generateDataAlternatif();

/*
|--------------------------------------------------------------------------
| FILTER KOMPETENSI
|--------------------------------------------------------------------------
| Hanya perusahaan yang memiliki minimal satu kecocokan kompetensi
| (C1 > 0) yang akan diproses menggunakan metode WASPAS.
| Perusahaan tanpa kecocokan kompetensi dieliminasi dari alternatif.
|--------------------------------------------------------------------------
*/
$data = array_filter($data, function ($item) {
    return $item['C1'] > 0;
});

if (empty($data)) {
    return redirect()
        ->route('rekomendasi')
        ->with(
            'error',
            'Tidak ditemukan perusahaan yang sesuai dengan kompetensi mahasiswa.'
        );
}
foreach ($data as $id => $item) {

    if ($item['C1'] == 0) {
        dump($id, $item);
    }

}

// =====================
// MAX & MIN
// =====================

foreach (['C1','C2','C3','C4'] as $c) {

    $col = array_column($data, $c);

    $max[$c] = max($col);
    $min[$c] = min($col);
}



// =====================
// NORMALISASI
// =====================

$normal = [];

foreach ($data as $industryId => $d) {

    $normal[$industryId] = [

        // BENEFIT
        'C1' => $max['C1'] == 0
            ? 0
            : $d['C1'] / $max['C1'],

        'C2' => $max['C2'] == 0
            ? 0
            : $d['C2'] / $max['C2'],

        // COST
        'C3' => $d['C3'] == 0
            ? 0
            : $min['C3'] / $d['C3'],

        'C4' => $d['C4'] == 0
            ? 0
            : $min['C4'] / $d['C4'],
    ];
}


// =====================
// HITUNG WASPAS
// =====================

$hasil = [];

foreach ($normal as $industryId => $n) {

    $wsm = 0;
    $wpm = 1;

    $detailWSM = [];
    $detailWPM = [];

    foreach ($n as $k => $val) {

        $w = $bobot[$k] ?? 0;

        $wsm += $w * $val;

        $wpm *= pow($val, $w);

        $detailWSM[] = [
            'kriteria' => $k,
            'normal'   => $val,
            'bobot'    => $w,
            'hasil'    => $val * $w,
        ];

        $detailWPM[] = [
            'kriteria' => $k,
            'normal'   => $val,
            'bobot'    => $w,
            'hasil'    => pow($val, $w),
        ];
    }

    $qi = (0.5 * $wsm) + (0.5 * $wpm);

    $alasan = [];

if ($normal[$industryId]['C1'] >= 0.8) {
    $alasan[] =
        'Kompetensi mahasiswa sangat sesuai';
}

if ($normal[$industryId]['C2'] >= 0.8) {
    $alasan[] =
        'Bidang minat mahasiswa sesuai';
}

if ($normal[$industryId]['C3'] >= 0.8) {
    $alasan[] =
        'Lokasi magang relatif dekat';
}

if ($normal[$industryId]['C4'] >= 0.8) {
    $alasan[] =
        'Biaya akomodasi relatif rendah';
}
$detailQi = [
    'bobot_wsm' => 0.5,
    'bobot_wpm' => 0.5,
    'nilai_wsm' => $wsm,
    'nilai_wpm' => $wpm,
    'hasil_wsm' => 0.5 * $wsm,
    'hasil_wpm' => 0.5 * $wpm,
];

$hasil[$industryId] = [

    'industry' => $data[$industryId]['industry'],

    'wsm' => $wsm,

    'wpm' => $wpm,

    'qi' => $qi,

    'detail_wsm' => $detailWSM,

    'detail_wpm' => $detailWPM,
    'detail_qi' => $detailQi,

    'alasan' => $alasan
];
}


uasort(
    $hasil,
    fn($a,$b)
        => $b['qi'] <=> $a['qi']
);

// =====================
// DATA UNTUK TAMPILAN
// =====================

$hasilView = array_values($hasil);

// Top 3 perusahaan
$top1 = $hasilView[0] ?? null;
$top2 = $hasilView[1] ?? null;
$top3 = $hasilView[2] ?? null;

// Ranking 4 dan seterusnya
$lainnya = array_slice($hasilView, 3);

// =====================
// SIMPAN DATABASE
// =====================
$rank = 1;

foreach ($hasil as $industryId => $h) {

    $hasilRekomendasi = HasilRekomendasi::create([

    'rekomendasi_id' => $rekomendasi->id,

    'industry_id' => $industryId,

    'qi' => $h['qi'],

    'ranking' => $rank,

    'wsm' => $h['wsm'],

    'wpm' => $h['wpm'],

    'n_c1' => $normal[$industryId]['C1'],
    'n_c2' => $normal[$industryId]['C2'],
    'n_c3' => $normal[$industryId]['C3'],
    'n_c4' => $normal[$industryId]['C4'],

]);

KonfirmasiRekomendasi::create([

    'rekomendasi_id' => $rekomendasi->id,

    'user_id' => Auth::id(),

    'industry_id' => $industryId,

    'hasil_rekomendasi_id' => $hasilRekomendasi->id,

    'ranking' => $rank,

    'nilai_waspas' => $h['qi'],

    'status' => 'direkomendasikan',

]);

    $rank++;
}

return view(
    'rekomendasi.waspas',
    compact(
        'hasil',
         'hasilView',
        'top1',
        'top2',
        'top3',
        'lainnya',
        'normal',
        'bobot',
        'data'
    )
);
}



    public function ranking()
    {
        $hasil = HasilRekomendasi::with('alternative.industry')

            ->orderBy('ranking', 'asc')
            ->get();

        // ambil pemenang
        $pemenang = $hasil->first();

        // ambil semua data nilai dari session (atau bisa dari DB kalau nanti disimpan)

        $nilai = session('nilai_alternatif') ?? [];

        $analisis = [];

        if ($pemenang && isset($nilai[$pemenang->alternative_id])) {
            $data = $nilai[$pemenang->alternative_id];

            // cari max & min
            // cari max & min
$maxC1 = max(array_column($nilai, 'C1'));
$maxC2 = max(array_column($nilai, 'C2'));
$minC3 = min(array_column($nilai, 'C3'));
$minC4 = min(array_column($nilai, 'C4'));

            // C1 Kompetensi
if ($data['C1'] >= ($maxC1 * 0.9)) {
    $analisis[] =
        'Kompetensi mahasiswa sangat sesuai';
}

// C2 Minat
if ($data['C2'] >= 3) {
    $analisis[] =
        'Minat mahasiswa sesuai';
}

// C3 Jarak
if ($data['C3'] == $minC3) {
    $analisis[] =
        'Lokasi relatif dekat';
}

// C4 Biaya
if ($data['C4'] == $minC4) {
    $analisis[] =
        'Biaya akomodasi rendah';
}
        }

        // fallback kalau kosong
        if (empty($analisis)) {
            $analisis[] = 'Memiliki kombinasi nilai terbaik dari seluruh kriteria';
        }

        return view('rekomendasi.ranking', compact('hasil', 'analisis'));
    }

    // ======================================================
// HISTORY
// ======================================================
    public function history()
{
    $history = RekomendasiSession::with([
        'hasil.industry'
    ])
    ->where('user_id', Auth::id())
    ->latest()
    ->get();

    $totalRiwayat = $history->count();

    $rekomendasiTerakhir = optional(
        $history->first()?->hasil
            ->sortBy('ranking')
            ->first()
    );

    $totalPerusahaan = $history
        ->flatMap(fn($h) => $h->hasil)
        ->count();

    return view(
        'rekomendasi.history',
        compact(
            'history',
            'totalRiwayat',
            'rekomendasiTerakhir',
            'totalPerusahaan'
        )
    );
}

// ======================================================
// PRIVATE FUNCTION
// ======================================================
private function getProfilKompetensi()
{
    $nilais = Nilai::where('user_id', Auth::id())
        ->with('mataKuliah.bidangKompetensi')
        ->get();

    $result = [];

    foreach ($nilais as $nilai) {

        $mataKuliah = $nilai->mataKuliah;

        if (!$mataKuliah) {
            continue;
        }

        $nilaiMutu = (float) $nilai->nilai_mutu;

        if ($nilaiMutu <= 0) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | Satu mata kuliah dapat memiliki lebih dari satu bidang
        |--------------------------------------------------------------------------
        */

        foreach ($mataKuliah->bidangKompetensi as $mapping) {

            $bidang = $mapping->bidang;

            if (!$bidang) {
                continue;
            }

            $semester = $nilai->semester;

            $result[$bidang][$semester][] = $nilaiMutu;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Hitung rata-rata setiap bidang
    |--------------------------------------------------------------------------
    */

    $profil = [];

    foreach ($result as $bidang => $semesters) {

        $totalNilaiSemester = 0;
        $jumlahSemester = 0;

        foreach ($semesters as $semester => $nilaiList) {

            if (empty($nilaiList)) {
                continue;
            }

            $rataSemester =
                array_sum($nilaiList)
                / count($nilaiList);

            $totalNilaiSemester += $rataSemester;

            $jumlahSemester++;
        }

        if ($jumlahSemester > 0) {

            $profil[$bidang] = round(
                $totalNilaiSemester / $jumlahSemester,
                2
            );
        }
    }


    return $profil;
}

private function getMinatMahasiswa()
{
    return MinatMahasiswa::where(
        'user_id',
        Auth::id()
    )
    ->pluck('bidang')
    ->map(fn($m) => strtolower($m))
    ->toArray();
}

private function generateDataAlternatif()
{


    $this->updateExpiredHold();
    $industries = Industry::with('masterWilayah')
    ->whereColumn(
        'kuota_terisi',
        '<',
        'kuota_magang'
    )
    ->get();
    $profil = $this->getProfilKompetensi();

    $minatMahasiswa =
        $this->getMinatMahasiswa();



    $data = [];

    foreach ($industries as $industry) {

        $skill = strtolower(
            $industry->kualifikasi_skill ?? ''
        );

     // =====================
        // C1 KOMPETENSI
        // =====================

        $c1 = $this->hitungC1(
            $skill,
            $profil
        );

        // =====================
        // C2 MINAT
        // =====================

        $c2 = $this->hitungC2(
            $skill,
            $minatMahasiswa
        );


        $data[$industry->id] = [

        'industry' => $industry,

        'C1' => $c1,
        'C2' => $c2,
        'C3' => optional($industry->masterWilayah)->jarak_km ?? 0,
        'C4' => optional($industry->masterWilayah)->estimasi_biaya_hidup ?? 0,
        'terisi' => $industry->kuota_terisi,
        'sisa' => max(
            0,
            $industry->kuota_magang
            -
            $industry->kuota_terisi
        ),

        'kuota' => $industry->kuota_magang,
        ];
            }


    return $data;


}

public function detailHistory($id)
{
    $rekomendasi = RekomendasiSession::with([
        'hasil.industry'
    ])->findOrFail($id);

    $hasil = $rekomendasi->hasil
        ->sortBy('ranking');

    $terbaik = $hasil->first();

    $bobot = json_decode(
    $rekomendasi->bobot_ahp,
    true
);

$alasan = [];

if ($terbaik) {

    $alasan[] = 'Memiliki skor Qi tertinggi yaitu '
        . number_format($terbaik->qi, 4);

    $alasan[] = 'Menjadi alternatif dengan ranking pertama';

    $alasan[] = 'Memiliki kombinasi bobot AHP dan nilai WASPAS terbaik';

    if (($bobot['C1'] ?? 0) > 0.3) {
        $alasan[] =
            'Kesesuaian kompetensi menjadi faktor dominan dalam keputusan';
    }

    if (($bobot['C2'] ?? 0) > 0.2) {
        $alasan[] =
            'Kesesuaian minat mahasiswa turut mempengaruhi rekomendasi';
    }
}

    return view(
        'rekomendasi.detail-history',
        compact(
            'rekomendasi',
            'hasil',
            'terbaik',
            'bobot',
            'alasan'
        )
    );
}

public function detailHasil($id)
{
    $hasil = HasilRekomendasi::with([
        'industry',
        'rekomendasi'
    ])->findOrFail($id);

    $bobot = json_decode(
        $hasil->rekomendasi->bobot_ahp,
        true
    );

    $cr = $hasil->rekomendasi->cr;

    return view(
        'rekomendasi.detail-hasil',
        compact(
            'hasil',
            'bobot',
            'cr'
        )
    );
}

/**
 * Menghitung nilai C1 (Kesesuaian Kompetensi).
 *
 * Nilai C1 diperoleh dari nilai kompetensi tertinggi
 * yang sesuai dengan kebutuhan kompetensi perusahaan.
 */
private function hitungC1(
    string $skill,
    array $profil
): float
{
    $nilaiKandidat = [];

    // WEB
    if ($this->containsAny($skill, self::WEB_KEYWORDS)) {
        $nilaiKandidat[] =
            $profil['Web Developer'] ?? 0;
    }

    // MOBILE
    if ($this->containsAny($skill, self::MOBILE_KEYWORDS)) {
        $nilaiKandidat[] =
            $profil['Mobile App Developer'] ?? 0;
    }

    // DATABASE
    if ($this->containsAny($skill, self::DATABASE_KEYWORDS)) {
        $nilaiKandidat[] =
            $profil['Administrator Basis Data'] ?? 0;
    }

    // NETWORK
    if ($this->containsAny($skill, self::NETWORK_KEYWORDS)) {
        $nilaiKandidat[] =
            $profil['Administrator Sistem & Jaringan'] ?? 0;
    }

    return !empty($nilaiKandidat)
        ? max($nilaiKandidat)
        : 0;
}


/**
 * Menghitung nilai C2 (Kesesuaian Minat).
 *
 * Skor:
 * 4 = kedua bidang minat sesuai
 * 3 = salah satu bidang minat sesuai
 * 1 = tidak ada bidang minat yang sesuai
 */
private function hitungC2(
    string $skill,
    array $minatMahasiswa
    ): int
{
     // Menghitung jumlah bidang minat mahasiswa
    // yang sesuai dengan kebutuhan kompetensi perusahaan.

    $jumlahMatch = 0;

    // WEB
    if (
        in_array('web developer', $minatMahasiswa)
        &&
        $this->containsAny($skill, self::WEB_KEYWORDS)
    ) {
        $jumlahMatch++;
    }

    // MOBILE
    if (
        in_array('mobile developer', $minatMahasiswa)
        &&
        $this->containsAny($skill, self::MOBILE_KEYWORDS)
    ) {
        $jumlahMatch++;
    }

    // DATABASE
    if (
        in_array('administrator basis data', $minatMahasiswa)
        &&
        $this->containsAny($skill, self::DATABASE_KEYWORDS)
    ) {
        $jumlahMatch++;
    }

    // NETWORK
    if (
        in_array('administrator sistem & jaringan', $minatMahasiswa)
        &&
        $this->containsAny($skill, self::NETWORK_KEYWORDS)
    ) {
        $jumlahMatch++;
    }

    // SCORING
    if ($jumlahMatch >= 2) {

        return 4;

    } elseif ($jumlahMatch == 1) {

        return 3;

    }

    return 1;

}

private function containsAny(string $text, array $keywords): bool
{
    foreach ($keywords as $keyword) {

        if (str_contains($text, $keyword)) {
            return true;
        }

    }

    return false;
}

private function updateExpiredHold()
{
    KonfirmasiRekomendasi::where('status', 'hold_aktif')
        ->where('hold_expired_at', '<=', now())
        ->update([

            'status' => 'expired',

            'activated_at' => null,

            'hold_started_at' => null,

            'hold_expired_at' => null,

        ]);
}
}
