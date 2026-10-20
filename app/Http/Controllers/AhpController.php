<?php

namespace App\Http\Controllers;


use App\Models\Kriteria;
use App\Models\PerbandinganKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AhpController extends Controller
{
    public function create()
{
    $kriteria = \App\Models\Kriteria::pluck('kode')->toArray();

    $pairs = [];

    for ($i = 0; $i < count($kriteria); $i++) {
        for ($j = $i + 1; $j < count($kriteria); $j++) {
            $pairs[] = [$kriteria[$i], $kriteria[$j]];
        }
    }

    return view('ahp.input', compact('pairs'));
}
public function store(Request $request)
{
    $userId = Auth::id();

    // hapus lama
    \App\Models\PerbandinganKriteria::where('user_id', $userId)->delete();

    foreach ($request->nilai as $k1 => $row) {
        foreach ($row as $k2 => $nilai) {

            \App\Models\PerbandinganKriteria::create([
                'user_id' => $userId,
                'kriteria_1' => $k1,
                'kriteria_2' => $k2,
                'nilai' => $nilai
            ]);
        }
    }

    return redirect('/rekomendasi')->with('success', 'Berhasil dihitung');
}
}