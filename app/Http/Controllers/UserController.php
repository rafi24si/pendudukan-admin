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
        $searchableColumns = ['name', 'email'];

        $dataUser = User::when($request->search, function ($q) use ($request, $searchableColumns) {
                $q->where(function ($query) use ($request, $searchableColumns) {
                    foreach ($searchableColumns as $col) {
                        $query->orWhere($col, 'like', '%' . $request->search . '%');
                    }
                });
            })
            ->paginate(10)
            ->onEachSide(2)
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
     * SIMPAN USER BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:Super Admin,Admin,User',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            // NORMALISASI ROLE ke sistem login
            $normalizedRole = strtolower(str_replace(' ', '', $request->role));
            // Super Admin → superadmin, Admin → admin, User → user

            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => $normalizedRole,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Gagal membuat user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
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
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:Super Admin,Admin,User',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        try {

            // NORMALISASI ROLE
            $normalizedRole = strtolower(str_replace(' ', '', $request->role));

            $data = [
                'name'  => $request->name,
                'email' => $request->email,
                'role'  => $normalizedRole,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error("Gagal update user ID {$id}: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
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
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
