<?php

namespace App\Http\Controllers;

use App\Models\MasterWilayah;
use Illuminate\Http\Request;

class MasterWilayahController extends Controller
{
    public function index()
    {
        $wilayah = MasterWilayah::orderBy('nama_wilayah')->paginate(10);

        return view('admin.master-wilayah.index', compact('wilayah'));
    }

    public function create()
    {
        return view('admin.master-wilayah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wilayah' => 'required|unique:master_wilayah,nama_wilayah',
            'provinsi' => 'required',
            'jarak_km' => 'required|numeric|min:0',
            'estimasi_biaya_hidup' => 'required|numeric|min:0',
        ]);

        MasterWilayah::create($request->all());

        return redirect()
            ->route('master-wilayah.index')
            ->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(MasterWilayah $masterWilayah)
{
    return view(
        'admin.master-wilayah.edit',
        compact('masterWilayah')
    );
}

    public function update(
    Request $request,
    MasterWilayah $masterWilayah
)
{
    $request->validate([

        'nama_wilayah' => 'required|string|max:100|unique:master_wilayah,nama_wilayah,' . $masterWilayah->id,

        'provinsi' => 'required|string|max:100',

        'jarak_km' => 'required|numeric|min:0',

        'estimasi_biaya_hidup' => 'required|numeric|min:0',

    ]);

    $masterWilayah->update([

        'nama_wilayah' => $request->nama_wilayah,

        'provinsi' => $request->provinsi,

        'jarak_km' => $request->jarak_km,

        'estimasi_biaya_hidup' => $request->estimasi_biaya_hidup,

    ]);

    return redirect()
        ->route('master-wilayah.index')
        ->with(
            'success',
            'Data wilayah berhasil diperbarui.'
        );
}

    public function destroy(MasterWilayah $masterWilayah)
{
    if ($masterWilayah->industries()->exists()) {

        $jumlah = $masterWilayah->industries()->count();

return redirect()
    ->back()
    ->with(
        'error',
        "Data wilayah tidak dapat dihapus karena masih digunakan oleh {$jumlah} perusahaan.
        Ubah atau hapus data perusahaan yang menggunakan wilayah ini terlebih dahulu, kemudian coba lagi."
    );
    }

    $masterWilayah->delete();

    return redirect()
        ->route('master-wilayah.index')
        ->with(
            'success',
            'Data wilayah berhasil dihapus.'
        );
}
}
