<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\PeristiwaKelahiran;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PeristiwaKelahiranController extends Controller
{
    public function index(Request $request)
    {
        $searchable = ['tempat_lahir', 'no_akta'];
        $filterable = [];

        $data['dataKelahiran'] = PeristiwaKelahiran::with(['bayi', 'ayah', 'ibu', 'media'])
            ->search($request, $searchable)
            ->filter($request, $filterable)
            ->orderBy('tgl_lahir', 'desc')
            ->paginate(8)
            ->withQueryString();

        return view('pages.peristiwa_kelahiran.index', $data);
    }

    public function create()
    {
        $data['warga'] = Warga::orderBy('nama')->get();
        return view('pages.peristiwa_kelahiran.create', $data);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'warga_id'      => 'required|exists:warga,warga_id',
            'tgl_lahir'     => 'required|date',
            'tempat_lahir'  => 'required|string|max:255',
            'ayah_warga_id' => 'nullable|exists:warga,warga_id',
            'ibu_warga_id'  => 'nullable|exists:warga,warga_id',
            'no_akta'       => 'nullable|unique:peristiwa_kelahiran,no_akta',
            'bukti'         => 'nullable|image|max:2048',
        ]);

        // SIMPAN DATA
        $kelahiran = PeristiwaKelahiran::create($validate);

        // SIMPAN FOTO JIKA ADA
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $path = $file->store('kelahiran', 'public');

            Media::create([
                'ref_table'  => 'peristiwa_kelahiran',
                'ref_id'     => $kelahiran->kelahiran_id,
                'file_url'   => $path,
                'caption'    => 'Bukti Kelahiran',
                'mime_type'  => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('peristiwa_kelahiran.index')
            ->with('success', 'Peristiwa kelahiran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['kelahiran'] = PeristiwaKelahiran::with('media')->findOrFail($id);
        $data['warga']     = Warga::orderBy('nama')->get();

        return view('pages.peristiwa_kelahiran.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);

        $validate = $request->validate([
            'warga_id'      => 'required|exists:warga,warga_id',
            'tgl_lahir'     => 'required|date',
            'tempat_lahir'  => 'required|string|max:255',
            'ayah_warga_id' => 'nullable|exists:warga,warga_id',
            'ibu_warga_id'  => 'nullable|exists:warga,warga_id',
            'no_akta'       => [
                'nullable',
                Rule::unique('peristiwa_kelahiran')->ignore($kelahiran->kelahiran_id, 'kelahiran_id'),
            ],
            'bukti'         => 'nullable|image|max:2048',
        ]);

        $kelahiran->update($validate);

        // UPDATE FOTO (HAPUS YANG LAMA)
        if ($request->hasFile('bukti')) {

            // HAPUS FOTO LAMA
            $oldMedia = Media::where('ref_table', 'peristiwa_kelahiran')
                ->where('ref_id', $kelahiran->kelahiran_id)
                ->first();

            if ($oldMedia) {
                Storage::disk('public')->delete($oldMedia->file_url);
                $oldMedia->delete();
            }

            // SIMPAN FOTO BARU
            $file = $request->file('bukti');
            $path = $file->store('kelahiran', 'public');

            Media::create([
                'ref_table'  => 'peristiwa_kelahiran',
                'ref_id'     => $kelahiran->kelahiran_id,
                'file_url'   => $path,
                'caption'    => 'Bukti Kelahiran',
                'mime_type'  => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('peristiwa_kelahiran.index')
            ->with('success', 'Peristiwa kelahiran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);

        // HAPUS FILE MEDIA
        $media = Media::where('ref_table', 'peristiwa_kelahiran')
            ->where('ref_id', $id)
            ->get();

        foreach ($media as $m) {
            Storage::disk('public')->delete($m->file_url);
            $m->delete();
        }

        // HAPUS DATA
        $kelahiran->delete();

        return redirect()->route('peristiwa_kelahiran.index')
            ->with('success', 'Data kelahiran berhasil dihapus!');
    }
}
