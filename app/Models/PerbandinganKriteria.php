<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerbandinganKriteria extends Model
{
    protected $table = 'perbandingan_kriteria';

    protected $fillable = [
        'user_id',
        'kriteria_1',
        'kriteria_2',
        'nilai'
    ];

    public $timestamps = false;

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
