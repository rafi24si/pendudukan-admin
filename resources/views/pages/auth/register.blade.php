<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Register | Sistem Kependudukan</title>

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
    <div
        class="w-full max-w-5xl bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <!-- LEFT BRAND -->
        <div class="hidden md:flex flex-col justify-center items-center bg-indigo-700 text-white p-10">
            <img src="{{ asset('assets/images/logo1.png') }}" class="w-100 mb-6" alt="Logo">

            <h2 class="text-3xl font-bold text-center mb-4">
                Sistem Informasi Kependudukan
            </h2>

            <p class="text-center text-indigo-100 leading-relaxed">
                Buat akun untuk mengelola data penduduk, keluarga, dan layanan administrasi desa secara digital.
            </p>
        </div>

        <!-- RIGHT FORM -->
        <div class="flex flex-col justify-center p-10">

            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">
                Daftar Akun Baru
            </h2>
            <p class="text-gray-500 text-center mb-6">
                Lengkapi data di bawah ini
            </p>

            <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                @csrf

                <!-- NAMA -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Nama lengkap" required>
                    @error('name')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                    @enderror
                </div>

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

                <!-- ROLE -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Role</label>
                    <select name="role"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        <option value="">— Pilih Role —</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
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

                <!-- KONFIRMASI -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="••••••••" required>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
                    Daftar
                </button>
            </form>

            <!-- LOGIN LINK -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun?
                <a href="{{ route('login.index') }}" class="text-indigo-600 font-medium hover:underline">
                    Login di sini
                </a>
            </p>
        </div>

    </div>

</body>

</html>
