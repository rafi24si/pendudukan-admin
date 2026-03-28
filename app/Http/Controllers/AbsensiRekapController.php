<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiRekapController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->get('start_date', Carbon::today()->toDateString());
        $end   = $request->get('end_date', Carbon::today()->toDateString());

        // =========================
        // 🔥 REKAP PER USER (REAL HITUNG JAM)
        // =========================
        $rekap = Absensi::join('users', 'users.id', '=', 'absensis.user_id')
            ->whereBetween('tanggal', [$start, $end])
            ->select(
                'users.id',
                'users.nama_ic',

                DB::raw('COUNT(absensis.id) as total_masuk'),

                // 🔥 HITUNG ULANG DARI JAM (FIX UTAMA)
                DB::raw('SUM(
                    CASE
                        WHEN absensis.jam_masuk IS NOT NULL
                        AND absensis.jam_keluar IS NOT NULL
                        THEN GREATEST(
                            TIMESTAMPDIFF(MINUTE, absensis.jam_masuk, absensis.jam_keluar),
                            0
                        )
                        ELSE 0
                    END
                ) as total_durasi')
            )
            ->groupBy('users.id', 'users.nama_ic')
            ->orderByDesc('total_durasi')
            ->get();

        // =========================
        // 🔥 RANKING (BERDASARKAN DURASI REAL)
        // =========================
        $ranking = Absensi::join('users', 'users.id', '=', 'absensis.user_id')
            ->whereBetween('tanggal', [$start, $end])
            ->select(
                'users.nama_ic',
                DB::raw('SUM(
                    CASE
                        WHEN absensis.jam_masuk IS NOT NULL
                        AND absensis.jam_keluar IS NOT NULL
                        THEN GREATEST(
                            TIMESTAMPDIFF(MINUTE, absensis.jam_masuk, absensis.jam_keluar),
                            0
                        )
                        ELSE 0
                    END
                ) as total_durasi')
            )
            ->groupBy('users.nama_ic')
            ->orderByDesc('total_durasi')
            ->limit(10)
            ->get();

        return view('pages.absensi.rekap', compact('rekap', 'ranking', 'start', 'end'));
    }
}
