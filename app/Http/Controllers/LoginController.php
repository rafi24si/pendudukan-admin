<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    /**
     * halaman login
     */
       public function index()
    {
        return view('pages.auth.login');
    }

    /**
     * halaman register
     */
    public function registerForm()
    {
        return view('pages.auth.register');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 6 karakter',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // Simpan session user
            session([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors(['password' => 'Email atau password salah.'])
                     ->withInput();
    }

    /**
     * Proses register
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
        ], [
            'name.required'      => 'Nama wajib diisi',
            'email.required'     => 'Email wajib diisi',
            'email.unique'       => 'Email sudah digunakan',
            'password.required'  => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login.index')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }


    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // hapus session
        $request->session()->forget([
            'user_id',
            'user_name',
            'user_email'
        ]);

        // atau flush semua session
        // $request->session()->flush();

        return redirect()->route('login.index')
            ->with('success', 'Anda sudah logout.');
    }
}
