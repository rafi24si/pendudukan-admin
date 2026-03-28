<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Register | Sistem Kependudukan</title>

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

    <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8">

        <!-- LOGO -->
        <div class="flex justify-center mb-4">
            <div class="bg-gray-900 p-3 rounded-full shadow-lg">
                <img src="{{ asset('assets/images/soa.png') }}" class="w-14 h-14 object-contain" alt="Logo">
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">
            Daftar Akun
        </h2>

        <p class="text-gray-500 text-center mb-6">
            Masukkan Nama IC untuk registrasi
        </p>

        <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
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
            <div class="relative">
                <label class="block text-sm text-gray-600 mb-1">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 pr-12"
                    placeholder="••••••••" required>

                <!-- ICON -->
                <button type="button" onclick="togglePassword('password', this)"
                    class="absolute right-3 top-9 text-gray-600">
                    👁️
                </button>

                @error('password')
                    <small class="text-red-600 text-sm">{{ $message }}</small>
                @enderror
            </div>

            <!-- KONFIRMASI -->
            <div class="relative">
                <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="password_confirmation"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-700 pr-12"
                    placeholder="••••••••" required>

                <!-- ICON -->
                <button type="button" onclick="togglePassword('confirm_password', this)"
                    class="absolute right-3 top-9 text-gray-600">
                    👁️
                </button>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-3 rounded-lg transition duration-300 shadow-lg hover:shadow-gray-500/50">
                Daftar
            </button>
        </form>

        <!-- LOGIN -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login.index') }}" class="text-gray-900 font-medium hover:underline">
                Login di sini
            </a>
        </p>

    </div>

    <!-- SCRIPT SHOW/HIDE -->
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
                el.innerText = "🙈";
            } else {
                input.type = "password";
                el.innerText = "👁️";
            }
        }
    </script>

</body>
</html>
