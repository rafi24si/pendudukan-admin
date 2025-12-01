<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class AnggotaKeluarga extends Model
{
    use HasFactory;

    protected $table = 'anggota_keluarga';
    protected $primaryKey = 'anggota_id';

    protected $fillable = [
        'kk_id',
        'warga_id',
        'hubungan',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // KK yang dimiliki anggota ini
    public function kk()
    {
        return $this->belongsTo(KeluargaKK::class, 'kk_id', 'kk_id');
    }

    // Data warga yang menjadi anggota
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE SEARCH & FILTER (mirip User & Warga)
    |--------------------------------------------------------------------------
    */

    public function scopeSearch($query, Request $request, array $columns)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request, $columns) {
                foreach ($columns as $col) {
                    $q->orWhere($col, 'LIKE', '%'.$request->search.'%');
                }
            });
        }
        return $query;
    }

    public function scopeFilter($query, Request $request, array $columns)
    {
        foreach ($columns as $col) {
            if ($request->filled($col)) {
                $query->where($col, $request->$col);
            }
        }
        return $query;
    }
}
