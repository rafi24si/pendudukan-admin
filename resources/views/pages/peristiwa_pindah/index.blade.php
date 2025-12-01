@extends('layouts.admin.app')
@section('title', 'Data Peristiwa Pindah')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .pindah-card {
            transition: .25s ease;
            border-radius: 14px;
            overflow: hidden;
        }

        .pindah-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 22px rgba(0, 0, 0, 0.18);
        }

        .move-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #e8f7ff;
            color: #0077b6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 12px;
        }

        .pm-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .pm-info {
            font-size: .9rem;
            color: #555;
            margin-bottom: 3px;
        }
    </style>
@endpush


@section('content')
    <div class="container-fluid px-3 px-lg-4 fade-in">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fa fa-truck-moving me-2"></i> Data Peristiwa Pindah</h5>
            <a href="{{ route('peristiwa_pindah.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Catat Pindah
            </a>
        </div>

        {{-- SEARCH --}}
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="Cari alasan / alamat tujuan / no surat">

                        <button type="submit" class="input-group-text">🔍</button>

                        @if (request('search'))
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary ms-2">Clear</a>
                        @endif
                    </div>
                </div>
            </div>
        </form>


        {{-- CARD GRID --}}
        <div class="row g-3">

            @forelse ($dataPindah as $p)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card pindah-card shadow-sm">

                        {{-- FOTO --}}
                        @if ($p->media->first())
                            <img src="{{ asset('storage/' . $p->media->first()->file_url) }}" class="w-100"
                                style="height:160px; object-fit:cover;" alt="Foto Peristiwa Pindah">
                        @else
                            <div class="w-100 d-flex justify-content-center align-items-center bg-light"
                                style="height:160px;">
                                <span class="text-muted">
                                    <i class="fa fa-image me-1"></i> Tidak ada foto
                                </span>
                            </div>
                        @endif

                        <div class="card-body">

                            <div class="move-icon">
                                <i class="fa fa-truck-moving"></i>
                            </div>

                            <div class="pm-title">
                                {{ $p->warga?->nama ?? 'Tidak diketahui' }}
                            </div>

                            <div class="pm-info">
                                <i class="fa fa-calendar me-1"></i>
                                Tgl Pindah: <strong>{{ $p->tgl_pindah }}</strong>
                            </div>

                            <div class="pm-info">
                                <i class="fa fa-map-location-dot me-1"></i>
                                Tujuan: <strong>{{ $p->alamat_tujuan }}</strong>
                            </div>

                            <div class="pm-info">
                                <i class="fa fa-comment-dots me-1"></i>
                                Alasan: <strong>{{ $p->alasan }}</strong>
                            </div>

                            <div class="pm-info">
                                <i class="fa fa-file-alt me-1"></i>
                                Surat: <strong>{{ $p->no_surat ?? '-' }}</strong>
                            </div>

                        </div>

                        <div class="card-footer bg-white border-0 d-flex justify-content-between">

                            <a href="{{ route('peristiwa_pindah.edit', $p->pindah_id) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-pen"></i>
                            </a>

                            <form action="{{ route('peristiwa_pindah.destroy', $p->pindah_id) }}" method="POST"
                                onsubmit="return confirm('Hapus data pindah {{ $p->warga?->nama }}?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            @empty

                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body text-center text-muted py-4">
                            Tidak ada data pindah.
                        </div>
                    </div>
                </div>
            @endforelse

        </div>


        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $dataPindah->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
