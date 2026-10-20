<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiScore extends Model
{
    protected $fillable = [
    'rekomendasi_id',
    'industry_id',
    'c2',
    'c3',
    'c4',
    'c5'
];

public function industry()
{
    return $this->belongsTo(Industry::class);
}

public function rekomendasi()
{
    return $this->belongsTo(RekomendasiSession::class);
}
}
