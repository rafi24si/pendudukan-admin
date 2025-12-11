    @extends('layouts.admin.app')
    @section('title', 'Data Anggota Keluarga')

    @push('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .anggota-card {
            transition: .25s ease;
            border-radius: 14px;
        }
        .anggota-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 22px rgba(0,0,0,0.15);
        }
        .profile-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #eef2ff;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #4f46e5;
            font-size: 22px;
            margin-bottom: 10px;
        }
        .anggota-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
        }
        .anggota-info {
            font-size: .9rem;
            color: #666;
        }
    </style>
    @endpush


    @section('content')
    <div class="container-fluid px-3 px-lg-4 fade-in">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fa fa-users me-2"></i> Data Anggota Keluarga</h5>
            <a href="{{ route('anggota_keluarga.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Tambah Anggota
            </a>
        </div>

        {{-- SEARCH --}}
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            value="{{ request('search') }}" placeholder="Cari hubungan / nama">
                        <button type="submit" class="input-group-text">🔍</button>

                        @if(request('search'))
                            <a href="{{ url('anggota_keluarga') }}"
                            class="btn btn-outline-secondary ms-2">Clear</a>
                        @endif
                    </div>
                </div>
            </div>
        </form>


        {{-- --- GROUP BY KK --- --}}
        @forelse ($dataAnggota as $kkId => $anggotaGroup)

            {{-- HEADER KK --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body bg-light">
                    <h5 class="mb-0">
                        <i class="fa fa-home me-2"></i>
                        No KK: <strong>{{ $anggotaGroup->first()->kk?->kk_nomor }}</strong>
                        <br>
                        <small class="text-muted">
                            Kepala Keluarga:
                            {{ $anggotaGroup->first()->kk?->kepalaKeluarga?->nama ?? '-' }}
                        </small>
                    </h5>
                </div>
            </div>

            {{-- GRID ANGGOTA --}}
            <div class="row g-3 mb-4">
                @foreach ($anggotaGroup as $a)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card anggota-card shadow-sm h-100">

                            <div class="card-body text-center">

                                {{-- ICON --}}
                                <div class="profile-icon">
                                    <i class="fa fa-user"></i>
                                </div>

                                {{-- NAMA --}}
                                <div class="anggota-name">
                                    {{ $a->warga?->nama }}
                                </div>

                                {{-- HUBUNGAN --}}
                                <div class="anggota-info">
                                    <i class="fa fa-users-gear me-1"></i>
                                    Hubungan: <strong>{{ $a->hubungan }}</strong>
                                </div>

                            </div>

                            {{-- FOOTER BUTTON --}}
                            <div class="card-footer bg-white border-0 d-flex justify-content-between">

                                <a href="{{ route('anggota_keluarga.edit', $a->anggota_id) }}"
                                class="btn btn-sm btn-warning">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <form action="{{ route('anggota_keluarga.destroy', $a->anggota_id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus anggota {{ $a->warga?->nama }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

        @empty

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center text-muted py-4">
                        Tidak ada data anggota keluarga.
                    </div>
                </div>
            </div>

        @endforelse


    </div>
    @endsection
