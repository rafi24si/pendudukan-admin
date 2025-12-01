<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Register</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <div class="flex min-h-screen">

        {{-- LEFT --}}
        <div class="w-1/2 bg-indigo-600 text-white flex flex-col justify-center items-center px-10">
            <img src="{{ asset('assets/images/logo.png') }}" class="w-32 mb-6" alt="Logo">

            <h2 class="text-3xl font-bold mb-4 text-center">Daftar Akun Baru</h2>
            <p class="text-lg text-center">Silakan isi data di bawah ini untuk membuat akun.</p>
        </div>

        {{-- RIGHT --}}
        <div class="w-1/2 flex justify-center items-center px-10">

            <div class="w-full max-w-md">

                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Register</h2>

                <form action="{{ route('register.process') }}" method="POST">
                    @csrf

                    {{-- NAMA --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border rounded px-3 py-2 focus:outline-indigo-500"
                            required>
                        @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border rounded px-3 py-2 focus:outline-indigo-500"
                            required>
                        @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-1">Password</label>
                        <input type="password" name="password"
                            class="w-full border rounded px-3 py-2 focus:outline-indigo-500"
                            required>
                        @error('password') <small class="text-red-600">{{ $message }}</small> @enderror
                    </div>

                    {{-- CONFIRM --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border rounded px-3 py-2 focus:outline-indigo-500"
                            required>
                    </div>

                    <button class="w-full bg-indigo-600 text-white font-semibold py-2 rounded hover:bg-indigo-700">
                        Register
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Sudah punya akun?
                    <a href="{{ route('login.index') }}" class="text-indigo-600 hover:underline">Login</a>
                </p>

            </div>
        </div>

    </div>

</body>

</html>
