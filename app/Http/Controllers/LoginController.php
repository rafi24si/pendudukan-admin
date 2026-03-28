<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    /**
     * Halaman Login
     */
    public function index()
    {
        return view('pages.auth.login');
    }

    /**
     * Halaman Register
     */
    public function registerForm()
    {
        return view('pages.auth.register');
    }

    /**
     * Proses Login (pakai nama_ic)
     */
    public function login(Request $request)
    {
        $request->validate([
            'nama_ic'  => 'required|string',
            'password' => 'required|min:6',
        ]);

        $user = User::where('nama_ic', $request->nama_ic)->first();

        // cek user
        if (! $user) {
            return back()->withErrors([
                'nama_ic' => 'Nama IC tidak terdaftar.',
            ])->withInput();
        }

        // cek password
        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->withInput();
        }

        // set session
        session([
            'user_id'   => $user->id,
            'nama_ic'   => $user->nama_ic,
            'user_role' => $user->role,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Login berhasil.');
    }

    /**
     * Proses Register (tanpa capslock wajib)
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_ic'  => 'required|string|unique:users,nama_ic',

            // 🔥 PASSWORD TANPA WAJIB CAPSLOCK
            'password' => [
                'required',
                'confirmed',
                Password::min(6)->letters(), // ❌ tidak pakai mixedCase
            ],
        ]);

        User::create([
            'nama_ic'  => $request->nama_ic,
            'password' => Hash::make($request->password),
            'role'     => 'member', // default
        ]);

        return redirect()->route('login.index')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index')
            ->with('success', 'Logout berhasil.');
    }
}
