<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilRekomendasi extends Model
{
    protected $table = 'hasil_rekomendasi';

    protected $fillable = [

    'rekomendasi_id',
    'industry_id',

    'qi',
    'ranking',

    'wsm',
    'wpm',

    'n_c1',
    'n_c2',
    'n_c3',
    'n_c4'
];

    public function industry()
    {
        return $this->belongsTo(
            Industry::class,
            'industry_id'
        );
    }

    public function rekomendasi()
    {
        return $this->belongsTo(
            RekomendasiSession::class,
            'rekomendasi_id'
        );
    }

    public function konfirmasiRekomendasi()
{
    return $this->hasOne(KonfirmasiRekomendasi::class);
}
}
