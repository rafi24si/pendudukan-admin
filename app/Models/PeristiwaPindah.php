<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class PeristiwaPindah extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_pindah';
    protected $primaryKey = 'pindah_id';

    protected $fillable = [
        'warga_id',
        'tgl_pindah',
        'alamat_tujuan',
        'alasan',
        'no_surat',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'pindah_id')
            ->where('ref_table', 'peristiwa_pindah');
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCHING
    |--------------------------------------------------------------------------
    */
    public function scopeSearch($query, Request $request, array $columns)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request, $columns) {
                foreach ($columns as $col) {
                    $q->orWhere($col, 'LIKE', "%{$request->search}%");
                }
            });
        }
        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | FILTERING
    |--------------------------------------------------------------------------
    */
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
