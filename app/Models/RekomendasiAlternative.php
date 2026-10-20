<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiAlternative extends Model
{
    public function industry()
{
    return $this->belongsTo(Industry::class, 'industry_id');
}
protected $fillable = [
    'rekomendasi_id',
    'industry_id'
];

public function rekomendasi()
{
    return $this->belongsTo(
        RekomendasiSession::class,
        'rekomendasi_id'
    );
}
}