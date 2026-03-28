<?php
namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /*
    |------------------------------------------------------------------
    | HALAMAN ABSENSI
    |------------------------------------------------------------------
    */
    public function index()
    {
        $userId = session('user_id');

        if (! $userId) {
            return redirect()->route('login.index')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $today = Carbon::today();

        // ambil semua absensi hari ini
        $absensis = Absensi::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->orderByDesc('id')
            ->get();

        // sesi aktif (belum keluar)
        $absensiAktif = $absensis->firstWhere('jam_keluar', null);

        return view('pages.absensi.index', compact('absensis', 'absensiAktif'));
    }

    /*
    |------------------------------------------------------------------
    | MASUK KOTA
    |------------------------------------------------------------------
    */
    public function masuk()
    {
        $userId = session('user_id');

        if (! $userId) {
            return redirect()->route('login.index');
        }

        return DB::transaction(function () use ($userId) {

            // cek apakah masih ada sesi aktif
            $aktif = Absensi::where('user_id', $userId)
                ->whereNull('jam_keluar')
                ->lockForUpdate()
                ->exists();

            if ($aktif) {
                return back()->with('error', 'Masih ada sesi aktif, silakan keluar dulu.');
            }

            Absensi::create([
                'user_id'   => $userId,
                'tanggal'   => now()->toDateString(),
                'jam_masuk' => now(),
            ]);

            return back()->with('success', 'Masuk kota berhasil.');
        });
    }

    /*
    |------------------------------------------------------------------
    | KELUAR KOTA (FIX DURASI)
    |------------------------------------------------------------------
    */
    public function keluar()
    {
        $userId = session('user_id');

        if (! $userId) {
            return redirect()->route('login.index');
        }

        return DB::transaction(function () use ($userId) {

            // ambil sesi aktif terakhir
            $absensi = Absensi::where('user_id', $userId)
                ->whereNull('jam_keluar')
                ->lockForUpdate()
                ->latest('id')
                ->first();

            if (! $absensi) {
                return back()->with('error', 'Tidak ada sesi aktif.');
            }

            $jamKeluar = now();

            // 🔥 FIX BUG TIME (anti minus)
            if ($absensi->jam_masuk && $jamKeluar->lessThan($absensi->jam_masuk)) {
                $jamKeluar = $absensi->jam_masuk;
            }

            // 🔥 FIX DURASI BIAR TIDAK 0 TERUS
            $durasi = 0;

            if ($absensi->jam_masuk) {

                // hitung detik dulu (lebih akurat)
                $detik = $jamKeluar->diffInSeconds($absensi->jam_masuk);

                // convert ke menit (minimal 1 menit)
                $durasi = max(1, floor($detik / 60));
            }

            $absensi->update([
                'jam_keluar'   => $jamKeluar,
                'durasi_menit' => $durasi,
            ]);

            return back()->with('success', 'Keluar kota berhasil.');
        });
    }
}
