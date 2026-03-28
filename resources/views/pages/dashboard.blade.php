@extends('layouts.admin.app')
@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Global & Animation */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card Styling */
        .mc-card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        /* Icon Decoration */
        .icon-shape {
            width: 48px;
            height: 48px;
            background: #212529;
            color: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* Table & List */
        .table thead th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            color: #6c757d;
            border: none;
        }

        .member-avatar {
            width: 35px;
            height: 35px;
            object-fit: cover;
            border-radius: 10px;
            background: #eee;
        }

        .activity-line {
            border-left: 2px dashed #dee2e6;
            padding-left: 20px;
            margin-left: 10px;
        }
    </style>
@endpush

    @section('content')
        <div class="container-fluid py-4 fade-in">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        <i class="fa-solid fa-gauge-high me-2"></i>Dashboard MC
                    </h3>
                    <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ session('user_name') ?? 'Soa' }}</strong>.
                        Berikut status klub hari ini.</p>
                </div>
                <div class="text-end d-none d-md-block">
                    <h6 class="mb-0 fw-bold">{{ date('l, d M Y') }}</h6>
                    <small class="text-muted" id="realtime-clock">00:00:00</small>
                </div>
            </div>

            {{-- STATS ROW --}}
            <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="card mc-card stat-card h-100 p-3 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-dark text-white shadow-sm me-3 rounded-3 d-flex justify-content-center align-items-center" style="width: 54px; height: 54px;">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.70rem; letter-spacing: 0.5px;">Total Anggota</small>
                        <h3 class="fw-bolder mb-0 text-dark">{{ $totalMembers ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card mc-card stat-card h-100 p-3 border-0 shadow-sm" style="border-left: 5px solid #212529 !important;">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.70rem; letter-spacing: 0.5px;">Petinggi (Officers)</small>
                        <h3 class="fw-bolder mb-0 text-dark">{{ $totalPetinggi ?? 0 }}</h3>
                    </div>
                    <div class="text-dark opacity-25 mt-1">
                        <i class="fa-solid fa-user-shield fa-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card mc-card stat-card h-100 p-3 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-light text-dark border shadow-sm me-3 rounded-3 d-flex justify-content-center align-items-center" style="width: 54px; height: 54px;">
                        <i class="fa-solid fa-motorcycle fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.70rem; letter-spacing: 0.5px;">Member Reguler</small>
                        <h3 class="fw-bolder mb-0 text-dark">{{ $totalMemberBiasa ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card mc-card stat-card h-100 p-3 border-0 shadow-sm bg-dark text-white">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <small class="d-block fw-bold text-uppercase" style="font-size: 0.70rem; letter-spacing: 0.5px; color: #adb5bd;">Gabung Bulan Ini</small>
                        <h3 class="fw-bolder mb-0 text-white">+{{ $memberBaruBulanIni ?? 0 }}</h3>
                    </div>
                    <div>
                        <span class="badge bg-success shadow-sm px-2 py-1" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-arrow-trend-up me-1"></i> New
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

            <div class="row g-4">
                {{-- RECENT MEMBERS TABLE --}}
                <div class="col-lg-8">
                    <div class="card mc-card h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark">Daftar Anggota Terbaru</h6>
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-dark">Lihat Semua</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Anggota</th>
                                        <th>Role</th>
                                        <th>Tanggal Gabung</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Loop data real dari database --}}
                                    @forelse($users as $u)
                                        <tr class="align-middle">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    {{-- Cek apakah user punya avatar Discord --}}
                                                    @if ($u->avatar)
                                                        <img src="{{ $u->avatar }}" alt="{{ $u->nama_ic }}"
                                                            class="member-avatar me-2 shadow-sm">
                                                    @else
                                                        <div
                                                            class="member-avatar d-flex align-items-center justify-content-center text-white bg-dark fw-bold me-2 shadow-sm">
                                                            {{ strtoupper(substr($u->nama_ic, 0, 1)) }}
                                                        </div>
                                                    @endif

                                                    <div>
                                                        <span class="d-block fw-bold">{{ $u->nama_ic }}</span>
                                                        {{-- Format ID jadi 4 digit, contoh: ID: #MC-0001 --}}
                                                        <small class="text-muted">ID:
                                                            #MC-{{ str_pad($u->id, 4, '0', STR_PAD_LEFT) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $roleStyle =
                                                        $u->role === 'petinggi'
                                                            ? 'bg-dark text-white'
                                                            : 'bg-light text-dark border';
                                                @endphp
                                                <span class="badge {{ $roleStyle }}">{{ ucfirst($u->role) }}</span>
                                            </td>
                                            <td>{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</td>
                                            <td class="text-center">
                                                {{-- Arahkan ke halaman edit user --}}
                                                <a href="{{ route('user.edit', $u->id) }}" class="btn btn-sm btn-outline-dark"
                                                    title="Lihat Profil">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="fa-solid fa-users-slash fs-4 mb-2 d-block opacity-50"></i>
                                                Belum ada data anggota yang terdaftar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ACTIVITY LOG --}}
                <div class="col-lg-4">
                    <div class="card mc-card h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="fw-bold mb-0">Log Aktivitas Klub</h6>
                        </div>
                        <div class="card-body">
                            <div class="activity-line">
                                <div class="mb-4 position-relative">
                                    <span class="fw-bold d-block small">Pendaftaran Member Baru</span>
                                    <p class="text-muted small mb-0">Admin menambahkan "Opie Winston" ke database.</p>
                                    <small class="text-secondary" style="font-size: 0.7rem;">2 Menit yang lalu</small>
                                </div>
                                <div class="mb-4 position-relative">
                                    <span class="fw-bold d-block small">Update Struktur Organisasi</span>
                                    <p class="text-muted small mb-0">User "Admin" mengubah role Chibs menjadi Petinggi.</p>
                                    <small class="text-secondary" style="font-size: 0.7rem;">1 Jam yang lalu</small>
                                </div>
                                <div class="position-relative">
                                    <span class="fw-bold d-block small">Backup Data Berhasil</span>
                                    <p class="text-muted small mb-0">Sistem melakukan sinkronisasi database anggota.</p>
                                    <small class="text-secondary" style="font-size: 0.7rem;">3 Jam yang lalu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                // Realtime Clock Logic
                function updateClock() {
                    const now = new Date();
                    const timeString = now.toLocaleTimeString('id-ID', {
                        hour12: false
                    });
                    document.getElementById('realtime-clock').innerText = timeString + " WIB";
                }
                setInterval(updateClock, 1000);
                updateClock();
            </script>
        @endpush
    @endsection
