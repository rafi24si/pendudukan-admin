<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Login | Sistem Kependudukan</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-image: url('{{ asset('assets/images/bg-kependudukan.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-900/60 backdrop-blur-sm">

    <!-- CONTAINER -->
    <div class="w-full max-w-4xl bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <!-- LEFT BRAND -->
        <div class="hidden md:flex flex-col justify-center items-center bg-indigo-700 text-white p-10">
            <img src="{{ asset('assets/images/logo1.png') }}" class="w-100 mb-6" alt="Logo">

            <h2 class="text-3xl font-bold text-center mb-4">
                Sistem Informasi Kependudukan
            </h2>

            <p class="text-center text-indigo-100 leading-relaxed">
                Aplikasi pendataan warga, keluarga, dan administrasi surat menyurat desa secara digital.
            </p>
        </div>

        <!-- RIGHT FORM -->
        <div class="flex flex-col justify-center p-10">

            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">
                Selamat Datang
            </h2>
            <p class="text-gray-500 text-center mb-6">
                Silakan login untuk melanjutkan
            </p>

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="you@example.com" required>
                    @error('email')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="••••••••" required>
                    @error('password')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                    @enderror
                </div>

                <!-- REMEMBER -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2 rounded">
                        <span class="text-gray-600">Ingat saya</span>
                    </label>

                    <a href="#" class="text-indigo-600 hover:underline">
                        Lupa password?
                    </a>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
                    Login
                </button>
            </form>

            <!-- REGISTER -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Belum punya akun?
                <a href="{{ route('register.index') }}" class="text-indigo-600 font-medium hover:underline">
                    Daftar sekarang
                </a>
            </p>
        </div>

    </div>

</body>
</html>
