<?php

namespace App\Http\Controllers;

use App\Models\KeluargaKK;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KeluargaKKController extends Controller
{
    public function index(Request $request)
    {
        $searchable = ['kk_nomor', 'alamat', 'rt', 'rw'];
        $filterable = [];

        $data['dataKK'] = KeluargaKK::with('kepalaKeluarga')
            ->filter($request, $filterable)
            ->search($request, $searchable)
            ->paginate(8)
            ->onEachSide(2)
            ->withQueryString();

        return view('pages.keluarga_kk.index', $data);
    }

    public function create()
    {
        $data['warga'] = Warga::orderBy('nama')->get(); // untuk dropdown kepala keluarga
        return view('pages.keluarga_kk.create', $data);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'kk_nomor'  => 'required|unique:keluarga_kk,kk_nomor',
            'kepala_keluarga_warga_id' => 'required|exists:warga,warga_id',
            'alamat'    => 'nullable|string',
            'rt'        => 'nullable|string',
            'rw'        => 'nullable|string',
        ]);

        KeluargaKK::create($validate);

        return redirect()->route('keluarga_kk.index')
            ->with('success', 'KK berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['kk'] = KeluargaKK::findOrFail($id);
        $data['warga'] = Warga::orderBy('nama')->get();

        return view('pages.keluarga_kk.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $kk = KeluargaKK::findOrFail($id);

        $validate = $request->validate([
            'kk_nomor' => [
                'required',
                Rule::unique('keluarga_kk', 'kk_nomor')->ignore($kk->kk_id, 'kk_id')
            ],
            'kepala_keluarga_warga_id' => 'required|exists:warga,warga_id',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
        ]);

        $kk->update($validate);

        return redirect()->route('keluarga_kk.index')
            ->with('success', 'KK berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KeluargaKK::findOrFail($id)->delete();

        return redirect()->route('keluarga_kk.index')
            ->with('success', 'KK berhasil dihapus!');
    }
}
