@extends('layouts.admin.app')
@section('title', 'Dashboard')

@push('styles')
    <style>
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card:hover {
            transform: translateY(-4px);
            transition: 0.25s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .list-hover:hover {
            background: #f5f7fa;
        }

        .bg-pink {
            background-color: #e83e8c !important;
        }
    </style>
@endpush


@section('content')
    <div class="container-fluid py-4 fade-in">

        {{-- HEADER --}}
        <div class="mb-4">
            <<h3 class="fw-bold">
                👋 Selamat Datang, {{ session('user_name') ?? 'Pengguna' }}!
                </h3>

                <p class="text-muted mb-0">Ringkasan informasi kependudukan terbaru.</p>
        </div>

        {{-- STATISTIK KOTAK --}}
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="p-3 rounded bg-primary text-white me-3">
                            <i class="fa fa-users fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Total Warga</h6>
                            <span class="text-muted">{{ $totalWarga ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="p-3 rounded bg-success text-white me-3">
                            <i class="fa fa-home fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Total KK</h6>
                            <span class="text-muted">{{ $totalKK ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="p-3 rounded bg-warning text-white me-3">
                            <i class="fa fa-baby fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Kelahiran</h6>
                            <span class="text-muted">{{ $totalKelahiran ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="p-3 rounded bg-danger text-white me-3">
                            <i class="fa fa-skull-crossbones fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Kematian</h6>
                            <span class="text-muted">{{ $totalKematian ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        {{-- PROGRESS KOMPOSISI DATA --}}
        <div class="row g-4 mb-4">

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Komposisi Jenis Kelamin</div>
                    <div class="card-body">

                        <label class="fw-bold">Laki-laki</label>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-primary" style="width: {{ $jumlahLaki ?? 0 }}%">
                                {{ $jumlahLaki ?? 0 }}%
                            </div>
                        </div>

                        <label class="fw-bold">Perempuan</label>
                        <div class="progress">
                            <div class="progress-bar bg-pink" style="width: {{ $jumlahPerempuan ?? 0 }}%">
                                {{ $jumlahPerempuan ?? 0 }}%
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Ringkasan Data RT / RW</div>
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">
                            <span>Total RT</span>
                            <strong>{{ $totalRT ?? 0 }}</strong>
                        </div>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-info" style="width: {{ ($totalRT ?? 0) * 10 }}%"></div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Total RW</span>
                            <strong>{{ $totalRW ?? 0 }}</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ ($totalRW ?? 0) * 10 }}%"></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>



        {{-- WARGA TERBARU & KEGIATAN TERBARU --}}
        <div class="row g-4">

            {{-- WARGA TERBARU --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Warga Terbaru</div>

                    <ul class="list-group list-group-flush">
                        @forelse ($wargaTerbaru ?? [] as $w)
                            <li class="list-group-item list-hover">
                                <strong>{{ $w->nama }}</strong>
                                <br>
                                <small class="text-muted">KTP: {{ $w->no_ktp }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-3">
                                Belum ada data terbaru.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- PERISTIWA TERBARU --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Peristiwa Terbaru</div>

                    <ul class="list-group list-group-flush">
                        @forelse ($peristiwaTerbaru ?? [] as $p)
                            <li class="list-group-item list-hover">
                                <strong>{{ $p->judul }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ \Illuminate\Support\Carbon::parse($p->created_at)->format('d M Y') }}
                                </small>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-3">
                                Belum ada peristiwa terbaru.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>

    </div>


    <div class="container py-5">
        <div class="row justify-content-center g-4">

            <!-- CARD 1 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="card shadow-lg text-center p-4" style="width: 22rem; border-radius: 16px;">

                    <h4 class="fw-bold text-primary mb-4">Identitas Pengembang</h4>

                    <!-- FOTO -->
                    <div class="mx-auto mb-3"
                        style="
                        width: 160px;
                        height: 160px;
                        border-radius: 50%;
                        overflow: hidden;
                        border: 4px solid #0d6efd;
                    ">
                        <img src="{{ asset('assets/images/fotosigit.jpeg') }}" alt="Foto Sigit Prasetyo"
                            style="width:100%; height:100%; object-fit:cover;">
                    </div>

                    <h5 class="fw-bold mb-1">Sigit Prasetyo</h5>
                    <p class="mb-1 text-muted">NIM: 245730101131</p>
                    <p class="mb-3 text-muted">Sistem Informasi</p>

                    <div class="d-flex justify-content-center gap-4 fs-3">
                        <a href="#" class="text-primary"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-github"></i></a>
                        <a href="#" class="text-danger"><i class="fab fa-instagram"></i></a>
                    </div>

                </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="card shadow-lg text-center p-4" style="width: 22rem; border-radius: 16px;">

                    <h4 class="fw-bold text-primary mb-4">Identitas Pengembang</h4>

                    <!-- FOTO -->
                    <div class="mx-auto mb-3"
                        style="
                        width: 160px;
                        height: 160px;
                        border-radius: 50%;
                        overflow: hidden;
                        border: 4px solid #0d6efd;
                    ">
                        <img src="{{ asset('assets/images/fotonaura.jpeg') }}" alt="Foto Naura Rahma Fadilah"
                            style="width:100%; height:100%; object-fit:cover;">
                    </div>

                    <h5 class="fw-bold mb-1">Naura Rahma Fadilah</h5>
                    <p class="mb-1 text-muted">NIM: 2457301111</p>
                    <p class="mb-3 text-muted">Sistem Informasi</p>

                    <div class="d-flex justify-content-center gap-4 fs-3">
                        <a href="#" class="text-primary"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-github"></i></a>
                        <a href="#" class="text-danger"><i class="fab fa-instagram"></i></a>
                    </div>

                </div>
            </div>

        </div>
    </div>


@endsection
