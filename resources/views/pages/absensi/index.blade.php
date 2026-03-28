@extends('layouts.admin.app')
@section('title', 'Absensi')


@section('content')

    <div class="container-fluid py-4">

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow border-0">
                    <div class="card-body">

                        {{-- HEADER --}}
                        <div class="text-center mb-3">
                            <h4 class="fw-bold">Absensi Kota</h4>
                            <small>{{ session('user_name') }}</small>
                        </div>

                        {{-- JAM REALTIME --}}
                        <div class="text-center mb-3">
                            <h3 id="clock"></h3>
                            <small>{{ date('d M Y') }}</small>
                        </div>

                        {{-- STATUS --}}
                        <div class="text-center mb-3">
                            @if ($absensiAktif)
                                <span class="badge bg-success">Sedang di Kota</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex flex-column align-items-center gap-2 mb-4">

                            @if (!$absensiAktif)
                                <form method="POST" action="{{ route('absensi.masuk') }}" class="w-50">
                                    @csrf
                                    <button class="btn btn-success w-100">
                                        Masuk Kota
                                    </button>
                                </form>
                            @endif

                            @if ($absensiAktif)
                                <form method="POST" action="{{ route('absensi.keluar') }}" class="w-50">
                                    @csrf
                                    <button class="btn btn-danger w-100">
                                        Keluar Kota
                                    </button>
                                </form>
                            @endif

                        </div>

                        {{-- HISTORY --}}
                        <h6 class="fw-bold mb-2">Riwayat Hari Ini</h6>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($absensis as $a)
                                        <tr>
                                            <td>{{ $a->jam_masuk?->format('H:i:s') }}</td>

                                            <td>
                                                {{ $a->jam_keluar?->format('H:i:s') ?? '-' }}
                                            </td>

                                            {{-- 🔥 DURASI FIX (AKURAT) --}}
                                            <td>
                                                @if ($a->jam_masuk && $a->jam_keluar)
                                                    @php
                                                        $diff = $a->jam_masuk->diff($a->jam_keluar);
                                                        $jam = $diff->h + $diff->days * 24; // biar aman kalau lebih dari 24 jam
                                                        $menit = $diff->i;
                                                    @endphp

                                                    <span class="fw-bold text-success">
                                                        {{ $jam }} jam {{ $menit }} menit
                                                    </span>
                                                @elseif ($a->jam_masuk)
                                                    @php
                                                        $now = now();
                                                        $diff = $a->jam_masuk->diff($now);
                                                        $jam = $diff->h + $diff->days * 24;
                                                        $menit = $diff->i;
                                                    @endphp

                                                    <span class="text-primary">
                                                        {{ $jam }} jam {{ $menit }} menit
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>
                                                @if (!$a->jam_keluar)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Belum ada absensi
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- ALERT --}}
                        @if (session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- 🔥 SCRIPT REALTIME --}}
    <script>
        // JAM REALTIME
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText =
                now.toLocaleTimeString('id-ID', {
                    hour12: false
                });
        }
        setInterval(updateClock, 1000);
        updateClock();


        // 🔥 DURASI REALTIME
        function updateDurasi() {
            document.querySelectorAll('.durasi-live').forEach(el => {

                const masuk = new Date(el.dataset.masuk);
                const sekarang = new Date();

                const diff = Math.floor((sekarang - masuk) / 1000); // detik

                const jam = Math.floor(diff / 3600);
                const menit = Math.floor((diff % 3600) / 60);
                const detik = diff % 60;

                el.innerText = `${jam}j ${menit}m ${detik}d`;
            });
        }

        setInterval(updateDurasi, 1000);
        updateDurasi();
    </script>

@endsection
