<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    protected $table = 'alternatif';

    protected $fillable = [
        'nama'
    ];

    public $timestamps = false;

    public function nilai()
    {
        return $this->hasMany(NilaiAlternatif::class);
    }
}