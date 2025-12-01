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
     * Tampilkan daftar anggota keluarga
     */
    public function index(Request $request)
    {
        $filterableColumns = ['kk_id'];
        $searchableColumns = ['hubungan'];

        $data['dataAnggota'] = AnggotaKeluarga::with(['kk', 'warga'])
            ->filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(8)
            ->onEachSide(2)
            ->withQueryString();

        return view('pages.anggota_keluarga.index', $data);
    }

    /**
     * Form tambah anggota keluarga
     */
    public function create()
    {
        $data['kkList'] = KeluargaKK::with('kepalaKeluarga')->orderBy('kk_nomor')->get();
        $data['wargaList'] = Warga::orderBy('nama')->get();

        return view('pages.anggota_keluarga.create', $data);
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

        // Cegah anggota duplikat dalam satu KK
        $exists = AnggotaKeluarga::where('kk_id', $request->kk_id)
            ->where('warga_id', $request->warga_id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'warga_id' => 'Warga ini sudah terdaftar sebagai anggota di KK tersebut.',
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
        $data['anggota']   = AnggotaKeluarga::with(['kk', 'warga'])->findOrFail($id);
        $data['kkList']    = KeluargaKK::with('kepalaKeluarga')->orderBy('kk_nomor')->get();
        $data['wargaList'] = Warga::orderBy('nama')->get();

        return view('pages.anggota_keluarga.edit', $data);
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

        // Cegah duplikat (kecuali diri sendiri)
        $exists = AnggotaKeluarga::where('kk_id', $request->kk_id)
            ->where('warga_id', $request->warga_id)
            ->where('anggota_id', '!=', $anggota->anggota_id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'warga_id' => 'Warga ini sudah terdaftar sebagai anggota di KK tersebut.',
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
