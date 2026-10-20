<?php

namespace App\Http\Controllers;

use App\Models\KonfirmasiRekomendasi;
use App\Models\RekomendasiSession;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KonfirmasiRekomendasiController extends Controller
{
    public function index()
    {
        $session = RekomendasiSession::where('user_id', Auth::id())
            ->latest()
            ->first();

        $konfirmasi = collect();

        if ($session) {

            $konfirmasi = KonfirmasiRekomendasi::with('industry')
                ->where('rekomendasi_id', $session->id)
                ->orderBy('ranking')
                ->get();

        }

        return view(
            'konfirmasi.index',
            compact(
                'konfirmasi',
                'session'
            )
        );
    }

   public function aktifkanHold($id)
{
    $konfirmasi = KonfirmasiRekomendasi::findOrFail($id);

    // Pastikan data milik mahasiswa yang login
    if ($konfirmasi->user_id != Auth::id()) {
        abort(403);
    }

    // =============================
// MAKSIMAL 2 HOLD
// =============================

$jumlahHold = KonfirmasiRekomendasi::where('user_id', Auth::id())
    ->where('status', 'hold_aktif')
    ->count();

if ($jumlahHold >= 2) {

    return back()->with(
        'error',
        'Maksimal hanya dapat mengaktifkan 2 Hold.'
    );

}

// =============================
// TIDAK BOLEH HOLD
// PERUSAHAAN YANG SAMA
// =============================

$sudahHold = KonfirmasiRekomendasi::where('user_id', Auth::id())
    ->where('industry_id', $konfirmasi->industry_id)
    ->where('status', 'hold_aktif')
    ->exists();

if ($sudahHold) {

    return back()->with(
        'error',
        'Perusahaan ini sudah Anda Hold.'
    );

}

    // =============================
    // CEK STATUS
    // =============================

    if ($konfirmasi->status != 'direkomendasikan') {

        return back()->with(
            'error',
            'Status tidak dapat diubah.'
        );

    }

    // =============================
    // CEK KUOTA HOLD
    // =============================

    $jumlahHold = KonfirmasiRekomendasi::where('industry_id', $konfirmasi->industry_id)
        ->whereIn('status', ['hold_aktif', 'diterima'])
        ->count();

    $kuotaMagang = $konfirmasi->industry->kuota_magang;

    if ($jumlahHold >= $kuotaMagang) {

        return back()->with(
            'error',
            'Kuota Hold perusahaan sudah penuh.'
        );

    }

    // =============================
    // AKTIFKAN HOLD
    // =============================

    $konfirmasi->update([

        'status' => 'hold_aktif',

        'activated_at' => now(),

        'hold_started_at' => now(),

        'hold_expired_at' => Carbon::now()->addDays(7),

    ]);

    return back()->with(
        'success',
        'Hold berhasil diaktifkan selama 7 hari.'
    );
}

public function batalkanHold($id)
{
    $konfirmasi = KonfirmasiRekomendasi::findOrFail($id);

    // Pastikan milik mahasiswa yang login
    if ($konfirmasi->user_id != Auth::id()) {
        abort(403);
    }

    // Hanya Hold Aktif yang bisa dibatalkan
    if ($konfirmasi->status != 'hold_aktif') {

        return back()->with(
            'error',
            'Hold tidak dapat dibatalkan.'
        );

    }

    // Kembalikan menjadi rekomendasi biasa
    $konfirmasi->update([

        'status' => 'direkomendasikan',

        'activated_at' => null,

        'hold_started_at' => null,

        'hold_expired_at' => null,

    ]);

    return back()->with(
        'success',
        'Hold berhasil dibatalkan.'
    );
}
}
