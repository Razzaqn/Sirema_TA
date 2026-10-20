<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiSession extends Model
{
    protected $table = 'rekomendasi_sessions';

    protected $fillable = [
    'user_id',
    'bobot_ahp',
    'cr'
];

    public function alternatives()
    {
        return $this->hasMany(
            RekomendasiAlternative::class,
            'rekomendasi_id'
        );
    }

    public function hasil()
    {
        return $this->hasMany(
            HasilRekomendasi::class,
            'rekomendasi_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function konfirmasiRekomendasi()
{
    return $this->hasMany(KonfirmasiRekomendasi::class, 'rekomendasi_id');
}
}
