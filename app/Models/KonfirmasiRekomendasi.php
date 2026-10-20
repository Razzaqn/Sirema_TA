<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfirmasiRekomendasi extends Model
{
    protected $table = 'konfirmasi_rekomendasi';

    protected $fillable = [
        'rekomendasi_id',
        'user_id',
        'industry_id',
        'hasil_rekomendasi_id',
        'ranking',
        'nilai_waspas',
        'status',
        'hold_started_at',
        'hold_expired_at',
        'activated_at',
    ];

    protected $casts = [
        'hold_started_at' => 'datetime',
        'hold_expired_at' => 'datetime',
        'activated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function hasilRekomendasi()
    {
        return $this->belongsTo(HasilRekomendasi::class);
    }
    public function rekomendasi()
{
    return $this->belongsTo(RekomendasiSession::class, 'rekomendasi_id');
}
}
