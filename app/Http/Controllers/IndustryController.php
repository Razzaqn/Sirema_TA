<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\BuktiPenerimaan;
use App\Models\Industry;
use App\Models\KonfirmasiRekomendasi;
use App\Models\RekomendasiSession;
use App\Models\MasterWilayah;
use Illuminate\Support\Facades\Storage;

class IndustryController extends Controller
{
      public function index()
    {
        $industries = Industry::all();
        return view('admin.industry.listindustry', compact('industries'));
    }

    public function create()
{
    $wilayah = MasterWilayah::orderBy('nama_wilayah')->get();

    return view(
        'admin.industry.create',
        compact('wilayah')
    );
}

    public function edit(Industry $industry)
{
    $wilayah = MasterWilayah::orderBy('nama_wilayah')->get();

    return view(
        'admin.industry.edit',
        compact(
            'industry',
            'wilayah'
        )
    );
}

public function update(Request $request, Industry $industry)
{
    $request->validate([
        'nama_industri' => 'required',
        'alamat_industri' => 'required',
        'kualifikasi_skill' => 'required',
        'kuota_magang' => 'required|integer|min:1',
          'master_wilayah_id' => 'required|exists:master_wilayah,id',
    ]);

    $industry->update([
        'nama_industri' => $request->nama_industri,
        'alamat_industri' => $request->alamat_industri,
        'kualifikasi_skill' => $request->kualifikasi_skill,
        'kuota_magang' => $request->kuota_magang,
    'master_wilayah_id' => $request->master_wilayah_id,
    ]);

    return redirect()
        ->route('industry.listindustry')
        ->with(
            'success',
            'Data perusahaan berhasil diperbarui.'
        );
}

public function destroy($id)
{
    $industry = Industry::findOrFail($id);

    $industry->delete();

    return redirect()
        ->back()
        ->with(
            'success',
            'Data perusahaan berhasil dihapus.'
        );
}

    public function store(Request $request)
{
    $request->validate([
        'nama_industri'     => 'required',
        'alamat_industri'   => 'required',
        'kualifikasi_skill' => 'required',
 'kuota_magang' => 'required|integer|min:1',
        'master_wilayah_id' => 'required|exists:master_wilayah,id',
    ]);

    Industry::create([
        'nama_industri'     => $request->nama_industri,
        'alamat_industri'   => $request->alamat_industri,
        'kualifikasi_skill' => $request->kualifikasi_skill,
'kuota_magang'      => $request->kuota_magang,
         'master_wilayah_id' => $request->master_wilayah_id,
    ]);

    return redirect()
        ->route('industry.listindustry')
        ->with('success', 'Perusahaan berhasil ditambahkan');
}

   public function listUser()
{
    $this->updateExpiredHold();
    $industries = Industry::with('masterWilayah')
    ->paginate(5);

$allIndustries = Industry::orderBy('nama_industri')->get();


    $buktiPenerimaan = BuktiPenerimaan::with([
    'industry',
    'user'
])

->latest()
->get();

$holdAktif = KonfirmasiRekomendasi::with('industry')
    ->where('user_id', Auth::id())
    ->where('status', 'hold_aktif')
    ->get();


    $totalPerusahaan = Industry::count();

$totalHoldAktif = KonfirmasiRekomendasi::where('status', 'hold_aktif')
    ->count();

$totalTersedia = Industry::whereColumn(
    'kuota_terisi',
    '<',
    'kuota_magang'
)->count();

// Ambil session rekomendasi terbaru milik mahasiswa
$sessionTerbaru = RekomendasiSession::where('user_id', Auth::id())
    ->latest()
    ->first();

// Data konfirmasi
$konfirmasi = collect();

if ($sessionTerbaru) {

    $konfirmasi = KonfirmasiRekomendasi::with('industry')
    ->where('rekomendasi_id', $sessionTerbaru->id)
    ->orderBy('ranking')
    ->take(5)
    ->get();
}
$konfirmasi->transform(function ($item) {

    $jumlahHold = KonfirmasiRekomendasi::where('industry_id', $item->industry_id)
        ->whereIn('status', ['hold_aktif', 'diterima'])
        ->count();

    $item->jumlah_hold = $jumlahHold;

    $item->sisa_kuota = max(
        0,
        $item->industry->kuota_magang - $jumlahHold
    );

    $item->persentase_hold = $item->industry->kuota_magang > 0
        ? round(($jumlahHold / $item->industry->kuota_magang) * 100)
        : 0;


        $holdAktif = KonfirmasiRekomendasi::with('user')
            ->where('industry_id', $item->industry_id)
            ->whereIn('status', ['hold_aktif', 'diterima'])
            ->orderBy('activated_at')
            ->get();

        $item->holdAktif = $holdAktif;
            return $item;
        });

    return view(
        'industryuser.index',
        compact(
    'industries',
    'allIndustries',
    'buktiPenerimaan',
    'totalPerusahaan',
     'holdAktif',
      'totalHoldAktif',
    'totalTersedia',
    'konfirmasi'
)
    );
}


public function uploadBukti(Request $request)
{
    $this->updateExpiredHold();

    $request->validate([
    'hold_id'    => 'required|exists:konfirmasi_rekomendasi,id',
    'file_bukti' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
]);

    // Cari Hold Aktif
    $hold = KonfirmasiRekomendasi::with('industry')
    ->where('id', $request->hold_id)
    ->where('user_id', Auth::id())
    ->where('status', 'hold_aktif')
    ->first();


    if (!$hold) {

        return back()->with(
            'error',
            'Anda belum memiliki Hold aktif.'
        );

    }

    // Cek apakah sudah upload
    $cek = BuktiPenerimaan::where('user_id', Auth::id())
        ->where('industry_id', $hold->industry_id)
        ->exists();

    if ($cek) {

        return back()->with(
            'error',
            'Bukti penerimaan sudah pernah diunggah.'
        );

    }

    $filePath = $request->file('file_bukti')
        ->store('bukti-penerimaan', 'public');

    // Simpan Bukti
    BuktiPenerimaan::create([

        'user_id' => Auth::id(),

        'industry_id' => $hold->industry_id,

        'file_bukti' => $filePath,

    ]);

    // Ubah status Hold
    $hold->update([

        'status' => 'diterima',

    ]);

    // Tambah kuota terisi
    $hold->industry->increment('kuota_terisi');

    KonfirmasiRekomendasi::where('user_id', Auth::id())
    ->where('status', 'hold_aktif')
    ->where('id', '!=', $hold->id)
    ->update([
        'status' => 'dibatalkan',
        'activated_at' => null,
        'hold_started_at' => null,
        'hold_expired_at' => null,
    ]);

    return redirect()
        ->route('industryuser.index')
        ->with(
            'success',
            'Bukti penerimaan berhasil diunggah.'
        );


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
