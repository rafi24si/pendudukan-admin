<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\KeluargaKK;
use App\Models\PeristiwaKelahiran;
use App\Models\PeristiwaKematian;
use App\Models\PeristiwaPindah;

use App\Models\Homestay;
use App\Models\KamarHomestay;
use App\Models\DestinasiWisata;
use App\Models\BookingHomestay;
use App\Models\UlasanWisata;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /* ============================
           STATISTIK WARGA
        ============================ */
        $totalWarga     = Warga::count();
        $totalKK        = KeluargaKK::count();
        $totalRT        = KeluargaKK::distinct('rt')->count('rt');
        $totalRW        = KeluargaKK::distinct('rw')->count('rw');
        $totalKelahiran = PeristiwaKelahiran::count();
        $totalKematian  = PeristiwaKematian::count();

        // Komposisi Gender
        $laki  = Warga::where('jenis_kelamin', 'L')->count();
        $perem = Warga::where('jenis_kelamin', 'P')->count();
        $totalGender = max($laki + $perem, 1);

        $jumlahLaki      = round(($laki / $totalGender) * 100);
        $jumlahPerempuan = 100 - $jumlahLaki;

        /* ============================
           WARGA TERBARU
        ============================ */
        $wargaTerbaru = Warga::orderByDesc('warga_id')->limit(5)->get();


        /* ============================
           PERISTIWA TERBARU
        ============================ */
        $peristiwa = collect();

        PeristiwaKelahiran::orderByDesc('tgl_lahir')->limit(5)->get()->each(function ($item) use ($peristiwa) {
            $peristiwa->push((object)[
                'judul'      => 'Kelahiran #' . $item->kelahiran_id . ' (Warga ID: ' . $item->warga_id . ')',
                'created_at' => $item->created_at ?? $item->tgl_lahir,
            ]);
        });

        PeristiwaKematian::orderByDesc('tgl_meninggal')->limit(5)->get()->each(function ($item) use ($peristiwa) {
            $peristiwa->push((object)[
                'judul'      => 'Kematian #' . $item->kematian_id . ' (Warga ID: ' . $item->warga_id . ')',
                'created_at' => $item->created_at ?? $item->tgl_meninggal,
            ]);
        });

        PeristiwaPindah::orderByDesc('tgl_pindah')->limit(5)->get()->each(function ($item) use ($peristiwa) {
            $peristiwa->push((object)[
                'judul'      => 'Pindah #' . $item->pindah_id . ' (Warga ID: ' . $item->warga_id . ')',
                'created_at' => $item->created_at ?? $item->tgl_pindah,
            ]);
        });

        $peristiwaTerbaru = $peristiwa->sortByDesc('created_at')->take(5)->values();


        /* ============================
           KIRIM KE VIEW
        ============================ */
        return view('pages.dashboard', [

            // Statistik Warga
            'totalWarga'        => $totalWarga,
            'totalKK'           => $totalKK,
            'totalRT'           => $totalRT,
            'totalRW'           => $totalRW,
            'totalKelahiran'    => $totalKelahiran,
            'totalKematian'     => $totalKematian,
            'jumlahLaki'        => $jumlahLaki,
            'jumlahPerempuan'   => $jumlahPerempuan,
            
            // Data List
            'wargaTerbaru'      => $wargaTerbaru,
            'peristiwaTerbaru'  => $peristiwaTerbaru,
        ]);
    }
}
