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
     * Proses Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // NORMALISASI ROLE (penting agar middleware tidak error)
            // Super Admin -> superadmin
            // Admin       -> admin
            // User        -> user
            $normalizedRole = strtolower(str_replace(' ', '', $user->role));

            session([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'user_role'  => $normalizedRole, // untuk middleware
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'password' => 'Email atau password salah.'
        ])->withInput();
    }

    /**
     * Proses Register
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(6)->letters()->mixedCase()->numbers()
            ],
            'role'     => 'required|in:Super Admin,Admin,User',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('login.index')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login.index')
            ->with('success', 'Anda sudah logout.');
    }
}
