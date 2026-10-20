<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
    'user_id',
    'mata_kuliah_id',
    'nilai',
    'nilai_mutu',
    'semester'
];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}