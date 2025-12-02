<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKematian;
use App\Models\Media;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PeristiwaKematianController extends Controller
{
    public function index(Request $request)
    {
        $searchable = ['sebab', 'lokasi', 'no_surat'];

        $data['dataKematian'] = PeristiwaKematian::with(['warga', 'media'])
            ->search($request, $searchable)
            ->orderBy('tgl_meninggal', 'desc')
            ->paginate(8)
            ->withQueryString();

        return view('pages.peristiwa_kematian.index', $data);
    }

    public function create()
    {
        $data['warga'] = Warga::orderBy('nama')->get();

        return view('pages.peristiwa_kematian.create', $data);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'warga_id'      => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date',
            'sebab'         => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'no_surat'      => 'nullable|unique:peristiwa_kematian,no_surat',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Simpan peristiwa
        $kematian = PeristiwaKematian::create($validate);

        // ======== UPLOAD FOTO JIKA ADA ========
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('peristiwa_kematian', 'public');

            Media::create([
                'ref_table' => 'peristiwa_kematian',
                'ref_id'    => $kematian->kematian_id,
                'file_url'  => $path,
                'caption'   => 'Foto Kematian',
                'mime_type' => $request->file('foto')->getMimeType(),
                'sort_order'=> 1
            ]);
        }

        return redirect()->route('peristiwa_kematian.index')
            ->with('success', 'Peristiwa kematian berhasil dicatat.');
    }

    public function edit($id)
    {
        $data['kematian'] = PeristiwaKematian::with('media')->findOrFail($id);
        $data['warga'] = Warga::orderBy('nama')->get();

        return view('pages.peristiwa_kematian.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);

        $validate = $request->validate([
            'warga_id'      => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date',
            'sebab'         => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'no_surat'      => [
                'nullable',
                Rule::unique('peristiwa_kematian')->ignore($kematian->kematian_id, 'kematian_id')
            ],
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kematian->update($validate);

        // ======== JIKA UPLOAD FOTO BARU ========
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($kematian->media->first()) {
                Storage::disk('public')->delete($kematian->media->first()->file_url);
                $kematian->media->first()->delete();
            }

            // Upload foto baru
            $path = $request->file('foto')->store('peristiwa_kematian', 'public');

            Media::create([
                'ref_table' => 'peristiwa_kematian',
                'ref_id'    => $kematian->kematian_id,
                'file_url'  => $path,
                'caption'   => 'Foto Kematian',
                'mime_type' => $request->file('foto')->getMimeType(),
                'sort_order'=> 1
            ]);
        }

        return redirect()->route('peristiwa_kematian.index')
            ->with('success', 'Peristiwa kematian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kematian = PeristiwaKematian::with('media')->findOrFail($id);

        // Hapus file foto
        if ($kematian->media->first()) {
            Storage::disk('public')->delete($kematian->media->first()->file_url);
            $kematian->media->first()->delete();
        }

        $kematian->delete();

        return redirect()->route('peristiwa_kematian.index')
            ->with('success', 'Data kematian berhasil dihapus.');
    }
}
