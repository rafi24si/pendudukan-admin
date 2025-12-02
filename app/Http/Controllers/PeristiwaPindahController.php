<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaPindah;
use App\Models\Media;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeristiwaPindahController extends Controller
{
    public function index(Request $request)
    {
        $searchable = ['alamat_tujuan', 'alasan', 'no_surat'];
        $filterable = [];

        $data['dataPindah'] = PeristiwaPindah::with(['warga', 'media'])
            ->search($request, $searchable)
            ->filter($request, $filterable)
            ->orderBy('tgl_pindah', 'desc')
            ->paginate(8)
            ->withQueryString();

        return view('pages.peristiwa_pindah.index', $data);
    }


    public function create()
    {
        $data['warga'] = Warga::orderBy('nama')->get();
        return view('pages.peristiwa_pindah.create', $data);
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            'warga_id'       => 'required|exists:warga,warga_id',
            'tgl_pindah'     => 'required|date',
            'alamat_tujuan'  => 'required|string|max:255',
            'alasan'         => 'required|string|max:255',
            'no_surat'       => 'nullable|unique:peristiwa_pindah,no_surat',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pindah = PeristiwaPindah::create($validate);

        // UPLOAD FOTO → media
        if ($request->hasFile('foto')) {

            $path = $request->file('foto')->store('peristiwa_pindah', 'public');

            Media::create([
                'ref_table' => 'peristiwa_pindah',
                'ref_id'    => $pindah->pindah_id,
                'file_url'  => $path,
                'caption'   => 'Foto Bukti Pindah',
                'mime_type' => $request->file('foto')->getMimeType(),
                'sort_order'=> 1
            ]);
        }

        return redirect()->route('peristiwa_pindah.index')
            ->with('success', 'Peristiwa pindah berhasil dicatat.');
    }


    public function edit($id)
    {
        $data['pindah'] = PeristiwaPindah::with('media')->findOrFail($id);
        $data['warga'] = Warga::orderBy('nama')->get();

        return view('pages.peristiwa_pindah.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $pindah = PeristiwaPindah::findOrFail($id);

        $validate = $request->validate([
            'warga_id'       => 'required|exists:warga,warga_id',
            'tgl_pindah'     => 'required|date',
            'alamat_tujuan'  => 'required|string|max:255',
            'alasan'         => 'required|string|max:255',
            'no_surat'       => [
                'nullable',
                Rule::unique('peristiwa_pindah')->ignore($pindah->pindah_id, 'pindah_id')
            ],
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pindah->update($validate);

        // Jika upload foto baru → hapus lama + simpan baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            foreach ($pindah->media as $m) {
                if ($m->file_url && file_exists(storage_path('app/public/'.$m->file_url))) {
                    unlink(storage_path('app/public/'.$m->file_url));
                }
                $m->delete();
            }

            // Upload baru
            $path = $request->file('foto')->store('peristiwa_pindah', 'public');

            Media::create([
                'ref_table' => 'peristiwa_pindah',
                'ref_id'    => $pindah->pindah_id,
                'file_url'  => $path,
                'caption'   => 'Foto Bukti Pindah',
                'mime_type' => $request->file('foto')->getMimeType(),
                'sort_order'=> 1
            ]);
        }

        return redirect()->route('peristiwa_pindah.index')
            ->with('success', 'Peristiwa pindah berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $pindah = PeristiwaPindah::with('media')->findOrFail($id);

        // hapus foto juga
        foreach ($pindah->media as $m) {
            if ($m->file_url && file_exists(storage_path('app/public/'.$m->file_url))) {
                unlink(storage_path('app/public/'.$m->file_url));
            }
            $m->delete();
        }

        $pindah->delete();

        return redirect()->route('peristiwa_pindah.index')
            ->with('success', 'Data pindah berhasil dihapus.');
    }
}
