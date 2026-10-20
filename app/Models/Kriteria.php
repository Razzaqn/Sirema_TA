<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';

    protected $fillable = [
        'kode',
        'nama'
    ];

    public $timestamps = false;

    // Relasi ke nilai alternatif
    public function nilaiAlternatif()
    {
        return $this->hasMany(NilaiAlternatif::class);
    }
}
