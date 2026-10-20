<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Nilai;
use App\Models\MataKuliah;
use App\Models\MinatMahasiswa;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

    $profilLengkap = false;

    if (Auth::check()) {

        $user = Auth::user();

        // Jumlah seluruh mata kuliah
        $totalMataKuliah = MataKuliah::count();

        // Jumlah nilai yang sudah diisi mahasiswa
        $totalNilaiMahasiswa = Nilai::where('user_id', $user->id)->count();

        // Kompetensi dianggap lengkap jika semua mata kuliah sudah memiliki nilai
        $kompetensiLengkap = ($totalNilaiMahasiswa >= $totalMataKuliah);

        // Minimal memilih satu bidang minat
        $minatLengkap = MinatMahasiswa::where('user_id', $user->id)->exists();

        $profilLengkap = $kompetensiLengkap && $minatLengkap;
    }

    $view->with('profilLengkap', $profilLengkap);
});
    }
}
