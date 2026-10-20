<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\MinatMahasiswa;
use App\Models\BuktiPenerimaan;
use App\Models\MataKuliah;

#[Fillable(['name', 'email', 'password', 'role',  'photo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function minatMahasiswa()
{
    return $this->hasMany(MinatMahasiswa::class);
}
public function buktiPenerimaan()
{
    return $this->hasMany(BuktiPenerimaan::class);
}

public function nilais()
{
    return $this->hasMany(Nilai::class);
}

public function rekomendasiSessions()
{
    return $this->hasMany(RekomendasiSession::class);
}

public function konfirmasiRekomendasi()
{
    return $this->hasMany(KonfirmasiRekomendasi::class);
}

public function isQualificationComplete(): bool
{
    // Total mata kuliah yang wajib diisi
    $totalMataKuliah = MataKuliah::count();

    // Total nilai yang sudah diinput mahasiswa
    $totalNilai = $this->nilais()->count();

    // Minimal memilih 1 minat
    $hasMinat = $this->minatMahasiswa()->exists();

    return $totalNilai >= $totalMataKuliah && $hasMinat;
}
}
