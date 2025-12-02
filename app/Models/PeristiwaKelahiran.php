<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class PeristiwaKelahiran extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_kelahiran';
    protected $primaryKey = 'kelahiran_id';

    protected $fillable = [
        'warga_id',
        'tgl_lahir',
        'tempat_lahir',
        'ayah_warga_id',
        'ibu_warga_id',
        'no_akta',
    ];

    /*
    |---------------------------------------------  -----------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // Bayi yang lahir
    public function bayi()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    // Ayah
    public function ayah()
    {
        return $this->belongsTo(Warga::class, 'ayah_warga_id', 'warga_id');
    }

    // Ibu
    public function ibu()
    {
        return $this->belongsTo(Warga::class, 'ibu_warga_id', 'warga_id');
    }

    // Media bukti kelahiran
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'kelahiran_id')
            ->where('ref_table', 'peristiwa_kelahiran');
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
    | FILTER
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
