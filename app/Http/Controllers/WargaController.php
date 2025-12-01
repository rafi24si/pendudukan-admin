<?php
namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $filterableColumns = [];
        $searchableColumns = ['nama', 'no_ktp', 'pekerjaan', 'email'];

        $data['dataWarga'] = Warga::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->onEachSide(2)
            ->withQueryString();

        return view('pages.warga.index', $data);
    }

    public function create()
    {
        return view('pages.warga.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_ktp'        => 'required|unique:warga,no_ktp|min:10',
            'nama'          => 'required|string',
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'agama'         => 'nullable|string',
            'pekerjaan'     => 'nullable|string',
            'telp'          => 'nullable|string',
            'email'         => 'nullable|email',
        ]);

        Warga::create($validate);

        return redirect()->route('warga.index')->with('success', 'Warga berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $warga = Warga::findOrFail($id);
        return view('pages.warga.edit', compact('warga'));
    }

    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        $validate = $request->validate([
            'no_ktp'        => ['required', Rule::unique('warga')->ignore($warga->warga_id, 'warga_id')],
            'nama'          => 'required|string',
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'agama'         => 'nullable|string',
            'pekerjaan'     => 'nullable|string',
            'telp'          => 'nullable|string',
            'email'         => 'nullable|email',
        ]);

        $warga->update($validate);

        return redirect()->route('warga.index')->with('success', 'Warga berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Warga::findOrFail($id)->delete();

        return redirect()->route('warga.index')->with('success', 'Warga berhasil dihapus!');
    }
}
