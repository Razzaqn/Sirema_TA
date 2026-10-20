<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterWilayah extends Model
{
    use HasFactory;

    protected $table = 'master_wilayah';

    protected $fillable = [

        'nama_wilayah',

        'provinsi',

        'jarak_km',

        'estimasi_biaya_hidup',

    ];

    public function industries()
    {
        return $this->hasMany(
            Industry::class,
            'master_wilayah_id'
        );
    }
}
