@extends('layouts.admin.app')
@section('title', 'Rekap Absensi')

@section('content')

    <div class="container-fluid py-4">

        <h4 class="fw-bold mb-4">Rekap Absensi</h4>

        {{-- 🔥 SUMMARY --}}
        @php
            $totalDurasi = $rekap->sum('total_durasi');
            $totalJam = floor($totalDurasi / 60);
            $totalMenit = $totalDurasi % 60;

            $totalUser = $rekap->count();
        @endphp

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 p-3">
                    <small class="text-muted">Total Jam Aktif</small>
                    <h5 class="fw-bold mb-0 text-success">
                        {{ $totalJam }} jam {{ $totalMenit }} menit
                    </h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 p-3">
                    <small class="text-muted">Total Member Aktif</small>
                    <h5 class="fw-bold mb-0">
                        {{ $totalUser }}
                    </h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 p-3">
                    <small class="text-muted">Rata-rata Jam</small>
                    <h5 class="fw-bold mb-0 text-primary">
                        {{ $totalUser ? floor($totalDurasi / $totalUser / 60) : 0 }} jam
                    </h5>
                </div>
            </div>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="row g-2 mb-4">
            <div class="col-md-3">
                <input type="date" name="start_date" value="{{ $start }}" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" value="{{ $end }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark w-100">Filter</button>
            </div>
        </form>

        <div class="row">

            {{-- 🔥 REKAP --}}
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Rekap Member</div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Total Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekap as $r)
                                    @php
                                        $durasi = (int) ($r->total_durasi ?? 0);
                                        if ($durasi < 0) {
                                            $durasi = 0;
                                        }

                                        $jam = intdiv($durasi, 60);
                                        $menit = $durasi % 60;
                                    @endphp

                                    <tr>
                                        <td>{{ $r->nama_ic }}</td>
                                        <td class="fw-bold text-success">
                                            {{ $jam }} jam {{ $menit }} menit
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 🔥 RANKING --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">🏆 Ranking Jam Aktif</div>
                    <div class="card-body">

                        @forelse($ranking as $index => $r)
                            @php
                                $durasi = max(0, $r->total_durasi);
                                $jam = floor($durasi / 60);
                                $menit = $durasi % 60;
                            @endphp

                            <div class="d-flex justify-content-between mb-2">

                                <span>
                                    @if ($index == 0)
                                        🥇
                                    @elseif($index == 1)
                                        🥈
                                    @elseif($index == 2)
                                        🥉
                                    @endif

                                    #{{ $index + 1 }} {{ $r->nama_ic }}
                                </span>

                                <span class="fw-bold text-success">
                                    {{ $jam }}j {{ $menit }}m
                                </span>

                            </div>
                        @empty
                            <p class="text-muted text-center">Belum ada data</p>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
