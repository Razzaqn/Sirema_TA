<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinatMahasiswa extends Model
{
     protected $table = 'minat_mahasiswa';

    protected $fillable = [
        'user_id',
        'bidang'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
