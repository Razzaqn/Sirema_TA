<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    public function alternatives()
{
    return $this->hasMany(RekomendasiAlternative::class);
}
protected $fillable = [
    'nama_industri',
    'alamat_industri',
    'kualifikasi_skill',
    'master_wilayah_id',
    'jarak_km',
    'biaya_akomodasi',
     'kuota_magang',
     'kuota_terisi',
];

public function buktiPenerimaan()
{
    return $this->hasMany(BuktiPenerimaan::class);
}

public function getHoldAktifAttribute()
{
    if ($this->relationLoaded('buktiPenerimaan')) {

        return $this->buktiPenerimaan

            ->count();

    }

    return $this->buktiPenerimaan()

        ->count();
}

public function getSisaKuotaAttribute()
{
    return max(
        0,
        $this->kuota_magang - $this->hold_aktif
    );
}

public function getKuotaPenuhAttribute()
{
    return $this->sisa_kuota <= 0;
}

public function konfirmasiRekomendasi()
{
    return $this->hasMany(KonfirmasiRekomendasi::class);
}

public function masterwilayah()
{
    return $this->belongsTo(
        MasterWilayah::class,
        'master_wilayah_id'
    );
}
}
