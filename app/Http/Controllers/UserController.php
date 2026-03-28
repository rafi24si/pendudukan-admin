<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * LIST USER
     */
    public function index(Request $request)
    {
        $dataUser = User::when($request->search, function ($q) use ($request) {
            $q->where('nama_ic', 'like', '%' . $request->search . '%');
        })
            ->paginate(10)
            ->withQueryString();

        return view('pages.user.index', compact('dataUser'));
    }

    /**
     * FORM TAMBAH USER
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * SIMPAN USER
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ic'  => 'required|string|max:100|unique:users,nama_ic',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:petinggi,member',
        ]);

        try {
            User::create([
                'nama_ic'  => trim($request->nama_ic),
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Gagal membuat user: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan user.');
        }
    }

    /**
     * FORM EDIT USER
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    /**
     * UPDATE USER
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ic'  => 'required|unique:users,nama_ic,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role'     => 'required|in:petinggi,member',
        ]);

        $user = User::findOrFail($id);

        try {
            $data = [
                'nama_ic' => $request->nama_ic,
                'role'    => $request->role,
            ];

            // update password jika diisi
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error("Gagal update user ID {$id}: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat update.');
        }
    }

    /**
     * HAPUS USER
     */
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();

            return redirect()->route('user.index')
                ->with('success', 'User berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error("Gagal hapus user ID {$id}: " . $e->getMessage());

            return redirect()->route('user.index')
                ->with('error', 'Terjadi kesalahan saat menghapus.');
        }
    }
}
