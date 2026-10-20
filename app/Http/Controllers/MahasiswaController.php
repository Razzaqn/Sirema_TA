<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Industry;
use App\Models\RekomendasiSession;
use App\Models\HasilRekomendasi;

class MahasiswaController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Total perusahaan
        $totalPerusahaan = Industry::count();

        // Total riwayat rekomendasi milik mahasiswa
        $totalRiwayat = RekomendasiSession::where(
            'user_id',
            $user->id
        )->count();

        // ==================================================
        // REKOMENDASI TERAKHIR
        // ==================================================
        // Ambil session rekomendasi terbaru milik user
        $sessionTerakhir = RekomendasiSession::with([
            'hasil.industry'
        ])
        ->where('user_id', $user->id)
        ->latest()
        ->first();

        // Ambil ranking 1 dari session tersebut
        $rekomendasiTerakhir = $sessionTerakhir?->hasil
            ->sortBy('ranking')
            ->first();

        // Cek kelengkapan kualifikasi mahasiswa
        $qualificationComplete = $user->isQualificationComplete();

        return view(
            'mahasiswa.dashboard',
            compact(
                'user',
                'totalPerusahaan',
                'totalRiwayat',
                'rekomendasiTerakhir',
                'qualificationComplete'
            )
        );
    }
}
