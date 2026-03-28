<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Login | Sistem Informasi Absensi SOA</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-image: url('{{ asset('assets/images/soa-png.png') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-900/60 backdrop-blur-sm">

    <div class="w-full max-w-4xl bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <!-- LEFT -->
        <div class="hidden md:flex flex-col justify-center items-center bg-gray-900 text-white p-10">
            <img src="{{ asset('assets/images/soa.png') }}" class="w-100 mb-6" alt="Logo">

            <h2 class="text-3xl font-bold text-center mb-4">
                Sistem Informasi Absensi
            </h2>

            <p class="text-center text-gray-300 leading-relaxed">
                Aplikasi Pendataan Absensi Soa Kota CeritaRoleplayku.
            </p>
        </div>

        <!-- RIGHT -->
        <div class="flex flex-col justify-center p-10">

            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">
                Selamat Datang
            </h2>

            <p class="text-gray-500 text-center mb-6">
                Login menggunakan Nama IC
            </p>

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf

                <!-- NAMA IC -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama IC</label>
                    <input type="text" name="nama_ic" value="{{ old('nama_ic') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700"
                        placeholder="Masukkan Nama IC" required>
                    @error('nama_ic')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700"
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

                    <a href="#" class="text-gray-700 hover:underline">
                        Lupa password?
                    </a>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-3 rounded-lg transition duration-300 shadow-lg">
                    Login
                </button>
            </form>

            <!-- REGISTER -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Belum punya akun?
                <a href="{{ route('register.index') }}" class="text-gray-900 font-medium hover:underline">
                    Daftar sekarang
                </a>
            </p>
        </div>

    </div>

</body>
</html>
