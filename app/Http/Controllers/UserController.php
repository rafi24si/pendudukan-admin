<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filterableColumns = [];
        $searchableColumns = ['name', 'email'];

        $data['dataUser'] = User::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->onEachSide(2)
            ->withQueryString();

        return view('pages.user.index', $data);
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Gagal membuat user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        try {
            $data = [
                'name'  => $request->name,
                'email' => $request->email,
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
