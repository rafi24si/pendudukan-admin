<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PeristiwaKematian extends Model
{
    use HasFactory;

    protected $table      = 'peristiwa_kematian';
    protected $primaryKey = 'kematian_id';

    protected $fillable = [
        'warga_id',
        'tgl_meninggal',
        'sebab',
        'lokasi',
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
        return $this->hasMany(Media::class, 'ref_id', 'kematian_id')
            ->where('ref_table', 'peristiwa_kematian')
            ->orderBy('sort_order');    
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
