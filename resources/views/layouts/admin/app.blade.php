<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>

    {{-- CSS global tema --}}
    @include('layouts.admin.css')

    {{-- CSS tambahan dari halaman --}}
    @stack('styles')

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <style>
        /* === Sesuaikan nilai berikut dgn tema/real size sidebar & header === */
        :root {
            --sidebar-w: 260px;
            /* lebar sidebar saat desktop */
            --sidebar-w-collapsed: 72px;
            /* lebar sidebar saat collapsible / mini */
            --header-h: 64px;
            /* tinggi topbar/navbar */
        }

        /* Jangan paksa sidebar jadi fixed di sini.
       Banyak tema (Spike/Argon) SUDAH mengatur posisinya sendiri.
       Kalau sidebar kamu TIDAK fixed dan perlu fixed, baru aktifkan block di bawah:
    **
    #sidenav-main, .sidenav, .sidebar { position: fixed; left: 0; top: 0; bottom: 0; width: var(--sidebar-w); z-index: 1040; }
    **
    */

        /* Konten utama */
        .main-content {
            min-height: 100vh;
            background: #f6f8fb;
            /* feel bebas, bisa diganti */
        }

        /* Area isi halaman (yang membungkus @yield('content')) */ .app-content {
            padding-top: calc(var(--header-h) + 12px);
            /* turun dari header */
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Offset kanan menyesuaikan sidebar */
        @media (min-width: 992px) {

            /* desktop */
            .app-content {
                margin-left: var(--sidebar-w);
            }
        }

        @media (min-width: 576px) and (max-width: 991.98px) {

            /* tablet (sidebar mini) */
            .app-content {
                margin-left: var(--sidebar-w-collapsed);
            }
        }

        /* mobile: margin-left 0 biar full width */
    </style>
</head>

<body class="bg-light">
    {{-- Sidebar --}}
    @include('layouts.admin.sidebar')

    {{-- Konten utama --}}
    <main class="main-content">
        {{-- Header/Topbar --}}
        @include('layouts.admin.header')

        {{-- WRAPPER KONTEN (semua halaman akan ada di dalam ini) --}}
        <div class="app-content">
            @yield('content')
        </div>

        {{-- Footer --}}
        @include('layouts.admin.footer')
    </main>

    {{-- JS global tema --}}
    @include('layouts.admin.js')

    {{-- JS tambahan dari halaman --}}
    @stack('scripts')
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ✅ SUCCESS MESSAGE --}}
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

{{-- ✅ ERROR MESSAGE --}}
@if ($errors->has('password'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login gagal!',
            text: '{{ $errors->first('password') }}',
        });
    </script>
@endif

</html>
