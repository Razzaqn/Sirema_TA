<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiAlternatif extends Model
{
    protected $table = 'nilai_alternatif';

    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'nilai'
    ];

    public $timestamps = false;

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}
