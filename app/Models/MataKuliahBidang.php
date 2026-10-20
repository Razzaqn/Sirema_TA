<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliahBidang extends Model
{
    protected $table = 'mata_kuliah_bidangs';

    protected $fillable = [
        'mata_kuliah_id',
        'bidang',
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
}
