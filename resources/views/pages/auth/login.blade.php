<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Login</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <div class="flex min-h-screen">

        {{-- LEFT --}}
        <div class="w-1/2 bg-indigo-600 text-white flex flex-col justify-center items-center px-10">
            <img src="{{ asset('assets/images/logo.png') }}" class="w-32 mb-6" alt="Logo">

            <h2 class="text-3xl font-bold mb-4 text-center">
                Sistem Informasi Kependudukan
            </h2>
            <p class="text-lg text-center">
                Selamat datang di aplikasi pendataan warga & keluarga.<br>
                Silakan login untuk melanjutkan.
            </p>
        </div>

        {{-- RIGHT --}}
        <div class="w-1/2 flex justify-center items-center px-10">
            <div class="w-full max-w-md">

                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Sign In</h2>

                @if (session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border rounded px-3 py-2 focus:outline-indigo-500"
                            placeholder="you@example.com" required>
                        @error('email')
                            <small class="text-red-600">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-1">Password</label>
                        <input type="password" name="password"
                            class="w-full border rounded px-3 py-2 focus:outline-indigo-500"
                            placeholder="••••••••" required>
                        @error('password')
                            <small class="text-red-600">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- REMEMBER --}}
                    <div class="flex items-center mb-4">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember" class="text-sm text-gray-600">Keep me logged in</label>
                    </div>

                    {{-- SUBMIT --}}
                    <button class="w-full bg-indigo-600 text-white font-semibold py-2 rounded hover:bg-indigo-700">
                        Login
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Belum punya akun?
                    <a href="{{ route('register.index') }}" class="text-indigo-600 hover:underline">
                        Daftar
                    </a>
                </p>

            </div>
        </div>

    </div>

</body>

</html>
