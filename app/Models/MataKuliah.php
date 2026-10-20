<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $fillable = [
        'nama',
        'bidang',
        'semester'
    ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function bidangKompetensi()
    {
        return $this->hasMany(MataKuliahBidang::class);
    }
}
