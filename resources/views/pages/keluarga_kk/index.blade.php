@extends('layouts.admin.app')
@section('title', 'Data Keluarga KK')

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .kk-card {
        transition: .25s;
        border-radius: 12px;
    }

    .kk-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .kk-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
    }

    .kk-subtitle {
        font-size: .9rem;
        color: #555;
    }

    .kk-info-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #eef2ff;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        color: #4f46e5;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4 fade-in">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa fa-list me-2"></i> Data Keluarga KK</h5>
        <a href="{{ route('keluarga_kk.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Tambah KK
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        value="{{ request('search') }}" placeholder="Search KK / Alamat / RT / RW">

                    <button type="submit" class="input-group-text">🔍</button>

                    @if(request('search'))
                        <a href="{{ url('keluarga-kk') }}"
                           class="btn btn-outline-secondary ms-2">Clear</a>
                    @endif
                </div>
            </div>
        </div>
    </form>



    {{-- CARD GRID --}}
    <div class="row g-3">

        @forelse ($dataKK as $kk)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card kk-card shadow-sm h-100">

                <div class="card-body">

                    {{-- ICON --}}
                    <div class="kk-info-icon mb-2">
                        <i class="fa fa-home"></i>
                    </div>

                    {{-- No KK --}}
                    <div class="kk-title">
                        {{ $kk->kk_nomor }}
                    </div>

                    {{-- Kepala Keluarga --}}
                    <div class="kk-subtitle mb-2">
                        <i class="fa fa-user me-1"></i>
                        Kepala: <strong>{{ $kk->kepalaKeluarga?->nama }}</strong>
                    </div>

                    {{-- Alamat --}}
                    <div class="kk-subtitle mb-1">
                        <i class="fa fa-map me-1"></i>
                        {{ $kk->alamat }}
                    </div>

                    {{-- RT/RW --}}
                    <div class="kk-subtitle">
                        <i class="fa fa-location-dot me-1"></i>
                        RT: <strong>{{ $kk->rt }}</strong> — RW: <strong>{{ $kk->rw }}</strong>
                    </div>

                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between">
                    {{-- EDIT --}}
                    <a href="{{ route('keluarga_kk.edit', $kk->kk_id) }}"
                       class="btn btn-sm btn-warning">
                       <i class="fa fa-pen"></i>
                    </a>

                    {{-- DELETE --}}
                    <form action="{{ route('keluarga_kk.destroy', $kk->kk_id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus KK {{ $kk->kk_nomor }}?');">
                        @csrf @method('DELETE')
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
                <div class="card-body text-center py-4 text-muted">
                    Tidak ada data KK.
                </div>
            </div>
        </div>

        @endforelse
    </div>



    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $dataKK->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
