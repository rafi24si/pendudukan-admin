<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKK;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaKeluargaController extends Controller
{
    /**
     * Tampilkan daftar anggota keluarga (Dikelompokkan berdasarkan KK)
     */
    public function index(Request $request)
    {
        // Ambil semua anggota + relasi KK + Warga
        $dataAnggota = AnggotaKeluarga::with(['kk.kepalaKeluarga', 'warga'])
            ->orderBy('kk_id')
            ->orderBy('hubungan')
            ->get()
            ->groupBy('kk_id'); // 👉 PENTING: Group berdasarkan KK

        return view('pages.anggota_keluarga.index', compact('dataAnggota'));
    }

    /**
     * Form tambah anggota keluarga
     */
    public function create()
    {
        $kkList = KeluargaKK::with('kepalaKeluarga')->orderBy('kk_nomor')->get();
        $wargaList = Warga::orderBy('nama')->get();

        return view('pages.anggota_keluarga.create', compact('kkList', 'wargaList'));
    }

    /**
     * Simpan anggota baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kk_id'     => ['required', 'exists:keluarga_kk,kk_id'],
            'warga_id'  => ['required', 'exists:warga,warga_id'],
            'hubungan'  => ['required', 'string', 'max:100'],
        ]);

        // Cegah duplikat anggota di KK yang sama
        $exists = AnggotaKeluarga::where('kk_id', $request->kk_id)
            ->where('warga_id', $request->warga_id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'warga_id' => 'Warga ini sudah terdaftar pada KK tersebut.',
            ]);
        }

        AnggotaKeluarga::create([
            'kk_id'    => $request->kk_id,
            'warga_id' => $request->warga_id,
            'hubungan' => $request->hubungan,
        ]);

        return redirect()->route('anggota_keluarga.index')
            ->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }

    /**
     * Form edit anggota keluarga
     */
    public function edit($id)
    {
        $anggota   = AnggotaKeluarga::with(['kk', 'warga'])->findOrFail($id);
        $kkList    = KeluargaKK::with('kepalaKeluarga')->orderBy('kk_nomor')->get();
        $wargaList = Warga::orderBy('nama')->get();

        return view('pages.anggota_keluarga.edit', compact('anggota', 'kkList', 'wargaList'));
    }

    /**
     * Update data anggota
     */
    public function update(Request $request, $id)
    {
        $anggota = AnggotaKeluarga::findOrFail($id);

        $request->validate([
            'kk_id'     => ['required', 'exists:keluarga_kk,kk_id'],
            'warga_id'  => ['required', 'exists:warga,warga_id'],
            'hubungan'  => ['required', 'string', 'max:100'],
        ]);

        // Cek duplikat kecuali dirinya sendiri
        $exists = AnggotaKeluarga::where('kk_id', $request->kk_id)
            ->where('warga_id', $request->warga_id)
            ->where('anggota_id', '!=', $anggota->anggota_id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'warga_id' => 'Warga ini sudah terdaftar pada KK tersebut.',
            ]);
        }

        $anggota->update([
            'kk_id'    => $request->kk_id,
            'warga_id' => $request->warga_id,
            'hubungan' => $request->hubungan,
        ]);

        return redirect()->route('anggota_keluarga.index')
            ->with('success', 'Anggota keluarga berhasil diperbarui!');
    }

    /**
     * Hapus anggota keluarga
     */
    public function destroy($id)
    {
        AnggotaKeluarga::findOrFail($id)->delete();

        return redirect()->route('anggota_keluarga.index')
            ->with('success', 'Anggota keluarga berhasil dihapus!');
    }
}
