<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPenerimaan extends Model
{
    protected $table = 'bukti_penerimaan';

    protected $fillable = [
        'user_id',
        'industry_id',
        'file_bukti',

    ];
    protected $casts = [

    'expired_at' => 'datetime',

];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}