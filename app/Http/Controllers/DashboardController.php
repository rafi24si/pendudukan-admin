<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog; // <-- 1. IMPORT MODEL LOG DI SINI
// (Import model lain seperti Warga, DestinasiWisata biarkan saja jika nanti dipakai)
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Tabel (5 User Terbaru)
        $users = User::latest()->take(5)->get();

        // 2. Data untuk 4 Widget/Card Statistik
        $totalMembers     = User::count();
        $totalPetinggi    = User::where('role', 'petinggi')->count();
        $totalMemberBiasa = User::where('role', 'member')->count();

        // Menghitung user yang baru gabung di bulan dan tahun ini
        $memberBaruBulanIni = User::whereMonth('created_at', date('m'))
                                  ->whereYear('created_at', date('Y'))
                                  ->count();

        // 4. Kirim semua variabel ke file View
        return view('pages.dashboard', [
            'users'              => $users,
            'totalMembers'       => $totalMembers,
            'totalPetinggi'      => $totalPetinggi,
            'totalMemberBiasa'   => $totalMemberBiasa,
            'memberBaruBulanIni' => $memberBaruBulanIni,
        ]);
    }
}
