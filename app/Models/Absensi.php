<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis'; // pastikan sama dengan migration

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'durasi_menit',
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'jam_masuk'   => 'datetime',
        'jam_keluar'  => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KE USER
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER (OPSIONAL - BIAR LEBIH MANTAP)
    |--------------------------------------------------------------------------
    */

    // cek sudah keluar atau belum
    public function isSelesai()
    {
        return !is_null($this->jam_keluar);
    }

    // format durasi jam
    public function getDurasiFormatAttribute()
    {
        if (!$this->durasi_menit) return '-';

        $jam = floor($this->durasi_menit / 60);
        $menit = $this->durasi_menit % 60;

        return "{$jam} Jam {$menit} Menit";
    }
}
