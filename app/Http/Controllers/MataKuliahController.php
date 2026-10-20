<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\MataKuliah;
use App\Models\MataKuliahBidang;

class MataKuliahController extends Controller
{
    private function bidangValid(): array
    {
        return [
            'Web Developer',
            'Mobile App Developer',
            'Administrator Basis Data',
            'Administrator Sistem & Jaringan Komputer',
        ];
    }

    public function index()
    {
        $data = MataKuliah::with('bidangKompetensi')
            ->orderBy('semester')
            ->get();

        return view(
            'admin.matakuliah.index',
            compact('data')
        );
    }

    public function create()
    {
        $bidangValid = $this->bidangValid();

        return view(
            'admin.matakuliah.create',
            compact('bidangValid')
        );
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',

        'bidang' => 'nullable|array',

        'bidang.*' => [
            'string',
            Rule::in($this->bidangValid()),
        ],

        'semester' => 'required|integer|min:1|max:3',
    ]);

    // Jika tidak ada bidang yang dipilih,
    // gunakan array kosong
    $bidangList = $request->input('bidang', []);

    // Simpan mata kuliah
    $mataKuliah = MataKuliah::create([
        'nama' => $request->nama,
        'semester' => $request->semester,

        // Kolom bidang lama masih dipertahankan
        // untuk sementara.
        // Jika tidak ada bidang, isi string kosong.
        'bidang' => $bidangList[0] ?? '',
    ]);

    // Simpan mapping bidang baru
    foreach ($bidangList as $bidang) {

        MataKuliahBidang::create([
            'mata_kuliah_id' => $mataKuliah->id,
            'bidang' => $bidang,
        ]);
    }

    return redirect()
        ->route('mk.index')
        ->with('success', 'Data berhasil ditambahkan');
}

    public function edit($id)
    {
        $data = MataKuliah::with('bidangKompetensi')
            ->findOrFail($id);

        $bidangValid = $this->bidangValid();

        return view(
            'admin.matakuliah.edit',
            compact('data', 'bidangValid')
        );
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',

        'bidang' => 'nullable|array',

        'bidang.*' => [
            'string',
            Rule::in($this->bidangValid()),
        ],

        'semester' => 'required|integer|min:1|max:3',
    ]);

    $data = MataKuliah::findOrFail($id);

    // Jika tidak ada bidang yang dipilih,
    // gunakan array kosong
    $bidangList = $request->input('bidang', []);

    // Update data utama
    $data->update([
        'nama' => $request->nama,
        'semester' => $request->semester,

        // Kolom lama tetap dipertahankan sementara
        'bidang' => $bidangList[0] ?? '',
    ]);

    // Hapus mapping bidang lama
    $data->bidangKompetensi()->delete();

    // Simpan mapping bidang baru
    foreach ($bidangList as $bidang) {

        MataKuliahBidang::create([
            'mata_kuliah_id' => $data->id,
            'bidang' => $bidang,
        ]);
    }

    return redirect()
        ->route('mk.index')
        ->with('success', 'Data berhasil diupdate');
}

    public function destroy($id)
    {
        MataKuliah::findOrFail($id)->delete();

        return back()
            ->with('success', 'Data berhasil dihapus');
    }
}
